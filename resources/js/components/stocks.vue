<template>
  <div class="field">
    <label class="label">Stocks</label>
    <div class="field is-grouped" v-for="(stock, index) in stocks" :key="index">
      <div class="control">
        <input
          type="text"
          :name="'products[' + index + '][quantity]'"
          v-model="select.quantity"
          placeholder="Quantity"
          class="input"
        />
      </div>
      <div class="control">
        <input
          type="text"
          :name="'products[' + index + '][cost]'"
          v-model="select.cost"
          placeholder="Cost"
          class="input"
        />
      </div>
      <div v-if="stocks.length > 1" class="control">
        <div @click="removeSelect(index)" class="button is-danger">Remove</div>
      </div>
    </div>
    <div class="field">
      <div class="control is-expanded">
        <a class="button is-fullwidth" @click="addStock">Add New Stock</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["stocksData"],
  data() {
    return {
      stocks: stocksData ? stocksData : [],
    };
  },
  methods: {
    addStock: function () {
      this.stocks.push({
        id: "new",
        code: null,
        name: null,
        price: null,
        tax: false
      });
    },
    removeStock: function (index) {
      this.stocks.splice(index, 1);
    },
  },
  data() {
    return {
      selects: [
        {
          product: null,
          quantity: null,
          cost: null,
        },
      ],
    };
  },
  computed: {
    sProducts: function () {
      return this.products.filter(function (product) {
        return product.stockable;
      });
    },
    rProducts: function () {
      let that = this;
      return this.sProducts.filter(function (product) {
        let index = that.selects.findIndex((select) =>
          select.product ? select.product.id === product.id : false
        );
        return index == -1;
      });
    },
    taxTotal: function () {
      let that = this;
      return _.round(
        _.reduce(
          that.selects,
          function (sum, select) {
            return (
              sum +
              (select.product
                ? ((select.cost * select.product.taxes[0].percent) /
                    (100 + select.product.taxes[0].percent)) *
                  select.quantity
                : 0)
            );
          },
          0
        ),
        3
      );
    },
    subTotal: function () {
      let that = this;
      return _.round(
        _.reduce(
          that.selects,
          function (sum, select) {
            return (
              sum +
              (select.product
                ? ((select.cost * 100) /
                    (100 + select.product.taxes[0].percent)) *
                  select.quantity
                : 0)
            );
          },
          0
        ),
        3
      );
    },
    grandTotal: function () {
      let that = this;
      return _.round(
        _.reduce(
          that.selects,
          function (sum, select) {
            return sum + (select.product ? select.cost * select.quantity : 0);
          },
          0
        ),
        3
      );
    },
  },
};
</script>
