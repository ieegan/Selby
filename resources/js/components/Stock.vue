<template>
  <div class="level is-mobile" :class="foundIndex ? 'stock-updater' : ''">
    <div class="level-left">
      <div v-if="!foundIndex" class="field has-addons">
        <p class="control">
          <span class="select">
            <select v-model="selectedQuantity">
              <option v-for="i in stock.quantity" v-text="i" :key="i"></option>
            </select>
          </span>
        </p>
        <p class="control">
          <a class="button is-static price">{{
            stock.final_price * selectedQuantity
          }}</a>
        </p>
      </div>
    </div>
    <div class="level-right">
      <button
        v-if="!foundIndex"
        class="button is-primary"
        @click="toggleCart(selectedQuantity)"
      >
        Add to Cart
      </button>
      <button
        v-if="foundIndex"
        class="button is-primary"
        @click="toggleCart(0)"
      >
        Remove from Cart
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["stock", "cart"],
  data() {
    return {
      foundIndex: null,
      selectedQuantity: 1,
    };
  },
  methods: {
    checkIndex: function () {
      var that = this;
      this.foundIndex =
        _.findIndex(that.cart, { s: that.stock.code }) == -1 ? false : true;
    },
    toggleCart: function (quantity) {
      this.$emit("toggle", this.stock.code, quantity);
      this.checkIndex();
    },
  },
  watch: {
    stock: function () {
      this.checkIndex();
    },
  },
  mounted() {
    this.checkIndex();
  },
};
</script>

<style>
</style>
