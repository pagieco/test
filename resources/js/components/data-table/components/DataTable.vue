<script>

import Cell from './Cell.vue';
import Footer from './Footer.vue';

export const ContentType = {
  Text: 'text',
  Numeric: 'numeric',
};

export const SortDirection = {
  Ascending: 'ascending',
  Descending: 'descending',
};

export default {
  components: { Cell, Footer },

  props: {
    /**
     * List of data types, which determines content alignment for each column.
     */
    columnContentTypes: {
      type: Array,
      required: true,
      validator: val => val.every(v => Object.values(ContentType).includes(v)),
    },

    /**
     * The direction to sort the table rows on first click or keypress of a sortable column heading.
     */
    defaultSortDirection: {
      type: String,
      default: SortDirection.Ascending,
      validator: val => Object
        .values(SortDirection)
        .includes(val),
    },

    /**
     * Content centered in the full width cell of the table footer row.
     */
    footerContent: {
      type: String,
    },

    /**
     * List of column headings.
     */
    headings: {
      type: Array,
      required: true,
    },

    /**
     * The index of the heading that the table rows are initially sorted by.
     * Defaults to the first column.
     */
    initialSortColumnIndex: {
      type: Number,
      default: 0,
    },

    /**
     * List of data points which map to table body rows.
     */
    rows: {
      type: Array,
      required: true,
    },

    /**
     * List of booleans, which maps to whether sorting is enabled or not for each column.
     */
    sortable: {
      type: Array,
    },

    /**
     * List of numeric column totals, highlighted in the table's header below column headings. Use empty strings
     * as placeholders or columns with no total.
     */
    totals: {
      type: Array,
    },
  },

  data() {
    return {
      currentSort: this.initialSortColumnIndex,
      currentSortDir: SortDirection.Ascending,
    };
  },

  mounted() {
    this.onSort(this.initialSortColumnIndex);
  },

  methods: {
    onSort(index) {
      if (index === this.currentSort) {
        this.currentSortDir = this.currentSortDir === SortDirection.Ascending
          ? SortDirection.Descending
          : SortDirection.Ascending;
      }

      this.currentSort = index;

      this.$emit('sort', {
        index,
        direction: this.currentSortDir,
      });
    },
  },
};

</script>

<template>
  <div class="data-table">
    <table class="data-table__table">
      <thead>
        <tr>

          <Cell v-for="(heading, headingIndex) in headings"
                scope="col"
                @sort="onSort(headingIndex)"
                :key="headingIndex"
                :content="heading"
                :content-type="columnContentTypes[headingIndex]"
                :sortable="sortable && sortable[headingIndex]"
                :header="true"
                :first-column="headingIndex === 0" />

        </tr>
        <tr>

          <Cell v-for="(heading, headingIndex) in totals"
                :key="headingIndex"
                :content="heading"
                :content-type="columnContentTypes[headingIndex]"
                :header="true"
                :total="true"
                :first-column="headingIndex === 0" />

        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, rowIndex) in rows"
            class="data-table__row"
            :key="rowIndex">

          <Cell v-for="(item, itemIndex) in row"
                :key="itemIndex"
                :content="item"
                :content-type="columnContentTypes[itemIndex]"
                :header="false"
                :first-column="itemIndex === 0" />

        </tr>
      </tbody>
    </table>

    <Footer v-if="footerContent" :content="footerContent" />

  </div>
</template>
