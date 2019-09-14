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
  /**
   * The component's properties.
   */
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

  /**
   * The component's data.
   */
  data() {
    return {
      isShown: this.isOpen,
      target: null,
    };
  },

  /**
   * The component's computed properties.
   */
  computed: {
    classList() {
      return [
        'popover',
        { hidden: !this.isShown },
      ];
    },
  },

  /**
   * The component's methods.
   */
  methods: {
    /**
     * Handle the click outside the popover.
     *
     * @param   {Event} e
     * @returns {void}
     */
    onBodyClick(e) {
      const { target } = this;

      if ((target && (target !== e.target)) && document.activeElement === document.body) {
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
