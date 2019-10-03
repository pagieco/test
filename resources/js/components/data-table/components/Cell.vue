<script>

// import { filterClassList } from '../../../utilities';
// import { Icon } from '../../icon';
// import { Link } from '../../link';
// import { TextStyle } from '../../..';

export default {
  props: {
    /**
     * The contents of the cell.
     */
    content: {
      type: [String, Number, Object],
      required: true,
    },

    /**
     * The content type of the cell.
     */
    contentType: {
      type: String,
      validator: val => ['text', 'numeric'].includes(val),
      required: true,
    },

    /**
     * Whether or not this is the first column in the row.
     */
    firstColumn: {
      type: Boolean,
      default: false,
    },

    /**
     * Determines that this is a header cell.
     */
    header: {
      type: Boolean,
      default: false,
    },

    /**
     * Determines that this cell displays the total amounts.
     */
    total: {
      type: Boolean,
      default: false,
    },

    /**
     * Determines that this cell is sortable.
     */
    sortable: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    classList() {
      return [
        'data-table__cell',
        [`data-table__cell--${this.contentType}`],
        { 'data-table__cell--header': this.header },
        { 'data-table__cell--total': this.total },
        { 'data-table__cell--first-column': this.firstColumn },
      ];
    },

    columnType() {
      return (this.header === true || this.firstColumn) ? 'th' : 'td';
    },
  },

  render(h) {
    return h(this.columnType, {
      class: this.classList,
      attrs: { 'aria-sort': 'none' },
    }, [
      this.getTotalsColumn(h),
      this.getSortableHeaderButton(h),
      this.getStringContents(h),
      this.getObjectContents(h),
    ]);
  },

  methods: {
    getTotalsColumn(h) {
      if (this.total) {
        return h(TextStyle, {
          props: { variation: 'strong' },
        }, this.firstColumn ? 'Totals' : this.content);
      }

      return null;
    },

    getSortableHeaderButton(h) {
      if (this.sortable) {
        // const sortIcon = h(Icon, {
        //   class: 'data-table__sort-button-icon',
        //   props: { name: 'sort' },
        // });

        return h('button', {
          class: 'data-table__sort-button',
          on: {
            click: () => this.$emit('sort'),
          },
        }, [null, this.content]);
      }

      return null;
    },

    getStringContents(h) {
      if (!this.sortable && !this.total && typeof this.content !== 'object') {
        return h('span', this.content);
      }

      return null;
    },

    getObjectContents(h) {
      if (!this.sortable && typeof this.content === 'object') {
        return h('a', { props: this.content }, [
          this.content.content,
        ]);
      }

      return null;
    },
  },
};

</script>
