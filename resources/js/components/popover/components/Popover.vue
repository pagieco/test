<script>

import Popper from 'popper.js';
import { isEmpty, pickBy } from 'lodash';

export const Placement = {
  TOP: 'top',
  RIGHT: 'right',
  BOTTOM: 'bottom',
  BOTTOM_START: 'bottom-start',
  BOTTOM_END: 'bottom-end',
  LEFT: 'left',
};

export default {
  props: {
    /*
     * When true, the Popover is manually shown.
     */
    isOpen: {
      type: Boolean,
      default: false,
    },

    placement: {
      type: String,
      default: Placement.BOTTOM,
      validator: val => Object
        .values(Placement)
        .includes(val),
    },

    offset: {
      type: String,
      default: '0,15',
    },
  },

  data() {
    return {
      isShown: this.isOpen,
      target: null,
    };
  },

  computed: {
    classList() {
      return [
        'popover',
        { 'hidden': ! this.isShown },
      ];
    },
  },

  methods: {
    /**
     * Handle the click outside the popover.
     *
     * @param   {Event} e
     * @returns {void}
     */
    onBodyClick(e) {
      const { target } = this;

      if (!this.isOutsidePopover(e.path)) {
        return;
      }

      if ((target && (target !== e.target)) || document.activeElement === document.body) {
        this.close();
      }
    },

    /**
     * When the esc key is pressed.
     *
     * @returns {void}
     */
    onEsc(e) {
      if (e.keyCode === 27) this.close();
    },

    /**
     * Toggle the popover.
     */
    toggle(target = null) {
      this.target = target;

      if (this.isShown) {
        this.close();
      } else {
        this.open(target);
      }
    },

    /**
     * Open the popover.
     */
    open(target = null) {
      if (this.isShown) {
        return;
      }

      this.isShown = true;
      this.target = target;

      document.body.addEventListener('click', this.onBodyClick, false);
      document.body.addEventListener('keydown', this.onEsc, false);

      if (target) {
        this.createPopperInstance(target);
      }

      this.$emit('open');
    },

    /**
     * Create a new Popper instance.
     *
     * @param   {Event} target
     * @returns {Popper}
     */
    createPopperInstance(target) {
      const { placement, offset } = this;

      return new Popper(target, this.$el, {
        placement,
        modifiers: {
          offset: { offset },
        },
      });
    },

    /**
     * Close the popover.
     */
    close() {
      if (!this.isShown) {
        return;
      }

      this.isShown = false;

      document.body.removeEventListener('click', this.onBodyClick, false);
      document.body.removeEventListener('keydown', this.onEsc, false);

      this.target = null;

      this.$emit('close');
    },

    /**
     * Determine if the given event path is inside the given className.
     *
     * @returns {Boolean}
     */
    isOutsidePopover(path) {
      const className = 'popover';

      return isEmpty(
        // Filter the given path by the classList which we later convert to a flat array
        // by spreading the object. Then get the element's classList and check if
        // the given className is included inside the classList array.
        pickBy(path, ({ classList }) => classList && [...classList].includes(className)),
      );
    },
  },
};

</script>

<template>
  <div role="dialog" :class="classList">
    <span ref="slot">
      <slot/>
    </span>
  </div>
</template>
