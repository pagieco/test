<script>

export default {
  props: {
    /**
     * Accessible label for the spinner.
     */
    accessibilityLabel: {
      type: String,
    },
  },
};

</script>

<template>
  <div class="spinner" role="status" :aria-label="accessibilityLabel">
    <svg width="20" height="20" stroke-width="16.00" viewBox="-3.00 -3.00 106.00 106.00">
      <path class="spinner__track" d="M 50,50 m 0,-45 a 45,45 0 1 1 0,90 a 45,45 0 1 1 0,-90"></path>
      <path class="spinner__head"
            d="M 50,50 m 0, -45 a 45, 45 0 1 1 0,90 a 45,45 0 1 1 0,-90"
            pathLength="280"
            stroke-dasharray="280 280"
            stroke-dashoffset="210"></path>
    </svg>
  </div>
</template>
