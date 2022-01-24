<template>
  <div class="form">
    <div class="level is-mobile">
      <div class="level-left">
        <h4>Items in Cart</h4>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small class="price">{{ cartTotals.total }}</small>
        </div>
      </div>
    </div>
    <ul class="item-list">
      <li class="item" v-for="(item, index) in rcart" :key="index">
        <input
          type="hidden"
          :name="'cart[' + index + '][quantity]'"
          :value="item.q"
        />
        <input
          v-if="item.s"
          type="hidden"
          :name="'cart[' + index + '][stock]'"
          :value="item.s"
        />
        <div class="media">
          <div class="media-left">
            <p class="image is-64x64">
              <img :src="item.stock.photo_absolute" />
            </p>
          </div>
          <div class="media-content" style="overflow-x: inherit">
            <small class="price">{{ item.stock.final_price * item.q }} </small>
            <h5>
              <a
                target="_blank"
                :href="'../product/' + item.stock.product.slug"
                >{{
                  item.stock.product.name +
                  (item.stock.name ? " - " + item.stock.name : "")
                }}</a
              >
            </h5>
            <div class="buttons are-small">
              <a @click="adjustQuantity(item, -1)" class="button is-primary"
                >-</a
              >
              <a class="button is-static">{{ item.q }}</a>
              <a
                v-show="item.q < item.stock.quantity"
                @click="adjustQuantity(item, 1)"
                class="button is-primary"
                >+</a
              >
            </div>
          </div>
          <div class="media-right">
            <a @click="adjustQuantity(item, 0)" class="delete"> </a>
          </div>
        </div>
      </li>
    </ul>
    <h4 class="spacing">Your Details</h4>
    <div class="field">
      <div class="control">
        <input
          name="name"
          class="input is-small"
          :class="errors.name ? 'is-danger' : ''"
          type="text"
          placeholder="Full name"
          v-model="name"
        />
        <div
          v-if="errors.name"
          v-text="errors.name"
          class="help is-danger"
        ></div>
      </div>
    </div>
    <div class="field">
      <div class="control">
        <div class="field has-addons is-marginless">
          <div class="control is-marginless">
            <a class="button is-small is-static">+960</a>
          </div>
          <div class="control is-expanded has-icons-right">
            <input
              type="text"
              placeholder="Mobile number"
              class="input is-small"
              :class="errors.phone ? 'is-danger' : ''"
              minlength="7"
              maxlength="7"
              size="7"
              v-model="phone"
              :readonly="otpStatus == 1 || otpStatus == 3 || otpStatus == 4"
            />
            <span v-if="otpStatus == 4" class="icon is-small is-right">
              <i class="fas fa-check"></i>
            </span>
          </div>
          <div class="control" v-if="phoneCheck">
            <a
              class="button is-small is-primary"
              v-if="otpStatus == 0"
              @click="otpPhone"
              >Send OTP</a
            >
            <button
              class="button is-small is-primary"
              v-if="otpStatus == 1"
              disabled
            >
              Sending OTP
            </button>
            <input
              type="text"
              placeholder="OTP"
              class="input is-small"
              minlength="6"
              maxlength="6"
              size="6"
              v-model="otp"
              v-if="otpStatus == 2"
            />
            <button
              class="button is-small is-primary"
              v-if="otpStatus == 3"
              disabled
            >
              Verifying OTP
            </button>
            <input
              type="text"
              placeholder="OTP"
              class="input is-small is-danger"
              minlength="6"
              maxlength="6"
              size="6"
              v-model="otp"
              v-if="otpStatus == 5"
            />
            <input type="hidden" name="method_id" v-model="method" />
            <input type="hidden" name="payment_id" v-model="payment" />
          </div>
        </div>
        <div
          v-if="errors.phone"
          v-text="errors.phone"
          class="help is-danger"
        ></div>
      </div>
    </div>
    <div
      class="tabs is-toggle is-fullwidth is-small"
      :class="errors.method ? 'is-danger' : ''"
    >
      <ul>
        <li
          v-for="m in methods"
          :key="m.id"
          v-bind:class="{ 'is-active': method == m.id }"
        >
          <a v-on:click="method = m.id" v-text="m.name"></a>
        </li>
      </ul>
    </div>
    <div
      v-if="errors.method"
      v-text="errors.method"
      class="help is-danger"
    ></div>
    <div class="tab-contents">
      <div class="content" v-if="method == 1">
        <div class="field">
          <div class="control">
            <input
              name="address[name]"
              type="text"
              placeholder="House name / Floor / Apartment no"
              class="input is-small"
              :class="errors.addressName ? 'is-danger' : ''"
              v-model="addressName"
            />
          </div>
          <div
            v-if="errors.addressName"
            v-text="errors.addressName"
            class="help is-danger"
          ></div>
        </div>
        <div class="field">
          <div class="control">
            <input
              name="address[road]"
              type="text"
              placeholder="Road name"
              class="input is-small"
              :class="errors.addressRoad ? 'is-danger' : ''"
              v-model="addressRoad"
            />
            <div
              v-if="errors.addressRoad"
              v-text="errors.addressRoad"
              class="help is-danger"
            ></div>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <div
              class="select is-small is-fullwidth"
              :class="errors.addressCity ? 'is-danger' : ''"
            >
              <select name="address[city]" v-model="addressCity">
                <option value="" selected="selected" disabled>
                  Select a city
                </option>
                <option
                  v-for="city in cities"
                  :value="city.id"
                  v-text="city.name"
                  :key="city.id"
                ></option>
              </select>
            </div>
            <div
              v-if="errors.addressCity"
              v-text="errors.addressCity"
              class="help is-danger"
            ></div>
          </div>
        </div>
        <div class="field" v-if="districtsFiltered.length > 0">
          <div class="control">
            <div
              class="select is-small is-fullwidth"
              :class="errors.addressDistrict ? 'is-danger' : ''"
            >
              <select name="address[district]" v-model="addressDistrict">
                <option value="" selected="selected" disabled>
                  Select a district
                </option>
                <option
                  v-for="district in districtsFiltered"
                  :value="district.id"
                  v-text="district.name"
                  :key="district.id"
                ></option>
              </select>
            </div>
            <div
              v-if="errors.addressDistrict"
              v-text="errors.addressDistrict"
              class="help is-danger"
            ></div>
          </div>
        </div>
      </div>
      <div class="content" v-if="method == 2">
        <div class="field">
          <div class="control">
            <input
              name="dropoff[name]"
              type="text"
              placeholder="Boat Name"
              class="input is-small"
              v-model="dropoffName"
              :class="errors.dropoffName ? 'is-danger' : ''"
            />
            <div
              v-if="errors.dropoffName"
              v-text="errors.dropoffName"
              class="help is-danger"
            ></div>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <textarea
              name="dropoff[note]"
              placeholder="Note"
              class="textarea is-small"
              v-model="dropoffNote"
              :class="errors.dropoffNote ? 'is-danger' : ''"
            ></textarea>
            <div
              v-if="errors.dropoffNote"
              v-text="errors.dropoffNote"
              class="help is-danger"
            ></div>
          </div>
        </div>
      </div>
      <div class="content" v-if="method == 3">
        <div class="field">
          <div class="control">
            <div
              class="select is-small is-fullwidth"
              :class="errors.pickupLocation ? 'is-danger' : ''"
            >
              <select name="pickup" v-model="pickupLocation">
                <option value="" selected="selected" disabled>
                  Select a store
                </option>
                <option
                  v-for="location in locations"
                  :value="location.id"
                  v-text="location.name + ' - ' + location.road"
                  :key="location.id"
                ></option>
              </select>
            </div>
            <div
              v-if="errors.pickupLocation"
              v-text="errors.pickupLocation"
              class="help is-danger"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment options -->
    <h4 class="spacing">Payment Details</h4>
    <div class="level is-mobile">
      <div class="level-left">
        <div class="level-item">
          <small>Sub Total</small>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small class="price" v-text="cartTotals.sub"></small>
        </div>
      </div>
    </div>
    <div class="level is-mobile">
      <div class="level-left">
        <div class="level-item">
          <small>Tax Total</small>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small class="price" v-text="cartTotals.taxes"></small>
        </div>
      </div>
    </div>
    <div class="level is-mobile" v-if="methodChargesTotal">
      <div class="level-left">
        <div class="level-item">
          <small>Total</small>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small class="price" v-text="cartTotals.total"></small>
        </div>
      </div>
    </div>
    <div v-if="methodChargesTotal">
      <div
        class="level is-mobile"
        v-for="charge in methodCharges"
        :key="charge.id"
      >
        <div class="level-left">
          <div class="level-item">
            <small v-text="charge.name"></small
            ><small style="opacity: 0.8; margin-left: 2px; font-size: 0.8em"
              >({{ charge.description }})</small
            >
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <small class="price" v-text="charge.amount"></small>
          </div>
        </div>
      </div>
    </div>
    <div class="level is-mobile">
      <div class="level-left">
        <div class="level-item">
          <small>Grand Total</small>
        </div>
      </div>
      <div class="level-right">
        <div class="level-item">
          <small class="price" v-text="grandTotal"></small>
        </div>
      </div>
    </div>
    <div
      class="tabs is-toggle is-fullwidth is-small"
      :class="errors.payment ? 'is-danger' : ''"
    >
      <ul>
        <li
          v-for="p in payments"
          :key="p.id"
          v-bind:class="{ 'is-active': payment == p.id }"
        >
          <a v-on:click="payment = p.id" v-text="p.name"></a>
        </li>
      </ul>
    </div>
    <div
      v-if="errors.payment"
      v-text="errors.payment"
      class="help is-danger"
    ></div>
    <div class="tab-contents">
      <div
        class="content is-small"
        v-for="p in payments"
        :key="p.id"
        v-show="payment == p.id"
      >
        <div v-if="p.id == 1 && payment == 1">
          <ol>
            <li>
              Copy our account number <b>{{ p.content }}</b>
            </li>
            <li>
              Send <b>MVR {{ grandTotal }}</b> to the account
            </li>
            <li>Attach the receipt below</li>
          </ol>
          <div
            class="file has-name is-fullwidth"
            :class="errors.paymentReceipt ? 'is-danger' : ''"
          >
            <label class="file-label">
              <input
                class="file-input"
                type="file"
                name="payment[receipt]"
                @change="processReceipt($event)"
              />
              <span class="file-cta">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>
                <span class="file-label">Choose your receipt</span>
              </span>
              <span class="file-name" v-text="paymentReceiptName"></span>
            </label>
          </div>
          <div
            v-if="errors.paymentReceipt"
            v-text="errors.paymentReceipt"
            class="help is-danger"
          ></div>
        </div>
        <div class="field has-addons" v-if="p.id == 2 && payment == 2">
          <div class="control is-expanded">
            <input
              name="payment[change]"
              class="input is-small"
              :class="errors.paymentChange ? 'is-danger' : ''"
              type="text"
              placeholder="Change"
              v-model="paymentChange"
            />
            <div
              v-if="errors.paymentChange"
              v-text="errors.paymentChange"
              class="help is-danger"
            ></div>
          </div>
          <div class="control">
            <a class="button is-small is-static">MVR</a>
          </div>
        </div>
      </div>
    </div>
    <button
      class="button is-primary is-small is-fullwidth"
      @click.prevent="validate"
    >
      Place order
    </button>
  </div>
</template>

<script>
export default {
  props: [
    "cart",
    "cities",
    "districts",
    "payments",
    "locations",
    "customer",
    "methods",
  ],
  data() {
    return {
      rcart: [],
      otp: "",
      otpStatus: Object.keys(this.customer).length ? 4 : 0, // 0 => unsent, 1=>sending, 2=> sent, 3=>verifying, 4=> correct, 5=>incorrect
      method: "",
      name: Object.keys(this.customer).length ? this.customer.name : "",
      phone: Object.keys(this.customer).length ? this.customer.phone : "",
      addressName: "",
      addressRoad: "",
      addressCity: "",
      addressDistrict: "",
      dropoffName: "",
      dropoffNote: "",
      pickupLocation: "",
      payment: "",
      paymentReceiptName: "",
      paymentChange: "",
      errors: {},
    };
  },
  methods: {
    otpPhone: function () {
      let that = this;
      that.otpStatus = 1;
      axios
        .post("/otp/phone", {
          phone: that.phone,
        })
        .then(function (response) {
          that.otpStatus = response.data.status == true ? 2 : 0;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    otpCode: function () {
      let that = this;
      that.otpStatus = 3;
      axios
        .post("/otp/code", {
          otp: that.otp,
        })
        .then(function (response) {
          if (response.data.status == true) {
            that.otpStatus = 4;
            that.customer = response.data.customer;
            that.name = that.name ? that.name : that.customer.name;
          } else {
            that.otpStatus = 5;
          }
          that.otp = "";
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    fetchRCart: function () {
      let that = this;
      axios
        .get("/api/cart", {
          params: {
            cart: JSON.stringify(that.cart),
          },
        })
        .then(function (response) {
          that.rcart = response.data;
        })
        .catch(function (error) {
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    },
    adjustQuantity: function (item, increment) {
      let that = this;
      let index = _.findIndex(that.rcart, { s: item.s });
      let quantity =
        increment != 0 ? parseInt(that.rcart[index].q) + increment : 0;

      if (quantity == 0) {
        _.pullAt(that.rcart, [index]);
      } else {
        that.rcart[index].q = quantity;
      }

      this.$emit("toggle", item.s, quantity);
    },
    processReceipt(event) {
      if (event.target.files[0]) {
        this.paymentReceiptName = event.target.files[0].name;
      }
    },
    validate: function () {
      this.errors = {};
      if (this.name.length < 1) {
        this.errors.name = "Name cannot be empty";
      }
      if (this.otpStatus != 4) {
        this.errors.phone = "Phone number needs to be verified.";
      }
      if (!this.method) {
        this.errors.method = "Please pick one of the methods above.";
      }
      if (this.method == 1) {
        if (!this.addressName) {
          this.errors.addressName = "Address name cannot be empty";
        }
        if (!this.addressRoad) {
          this.errors.addressRoad = "Address road cannot be empty";
        }
        if (!this.addressCity) {
          this.errors.addressCity = "Please pick a city";
        }
        if (
          this.addressCity &&
          this.districtsFiltered.length > 0 &&
          !this.addressDistrict
        ) {
          this.errors.addressDistrict = "Please pick a district";
        }
      }
      if (this.method == 2) {
        if (!this.dropoffName) {
          this.errors.dropoffName = "Boat name cannot be empty";
        }
        if (!this.dropoffNote) {
          this.errors.dropoffNote = "Please write a note";
        }
      }
      if (this.method == 3) {
        if (!this.pickupLocation) {
          this.errors.pickupLocation = "Please select a store to pickup from";
        }
      }
      if (!this.payment) {
        this.errors.payment = "Please pick one of the payment methods";
      }
      if (this.payment == 1) {
        if (!this.paymentReceiptName) {
          this.errors.paymentReceipt =
            "Please attach your payment transfer receipt";
        }
      }
      if (this.payment == 2) {
        if (!this.paymentChange) {
          this.errors.paymentChange =
            "Specify the cash amount you need change for";
        } else if (isNaN(this.paymentChange)) {
            this.errors.paymentChange =
            "Change can only contain numbers";
        }
      }
      var status = true
      Object.keys(this.errors).forEach((key) => {
          if (this.errors[key]){
              status = false
          }
      });
      if (status){
          $('#form').submit();
      }
    },
  },
  computed: {
    phoneCheck: function () {
      return !isNaN(this.phone) && this.phone.length == 7 ? true : false;
    },
    otpCheck: function () {
      return !isNaN(this.otp) && this.otp.length == 6 ? true : false;
    },
    districtsFiltered: function () {
      let that = this;
      return this.districts.filter(
        (district) => district.city_id == that.addressCity
      );
    },
    cartTotals: function () {
      let that = this;
      let e = _.round(
        _.reduce(
          that.rcart,
          function (sum, item) {
            return sum + item.stock.price * item.q;
          },
          0
        ),
        3
      );
      let c = _.round(
        _.reduce(
          that.rcart,
          function (sum, item) {
            return sum + item.stock.taxes_total * item.q;
          },
          0
        ),
        3
      );
      let i = _.round(
        _.reduce(
          that.rcart,
          function (sum, item) {
            return sum + item.stock.final_price * item.q;
          },
          0
        ),
        3
      );
      return {
        sub: e,
        taxes: c,
        total: i,
      };
    },
    methodCharges: function () {
      let that = this;
      let index = _.findIndex(that.methods, { id: that.method });
      if (index == -1) return false;
      let charges = that.methods[index].charges;
      charges.forEach((charge, i) => {
        let condition = false;
        condition = charge.min
          ? that.cartTotals.total > charge.min
            ? true
            : false
          : true;
        condition = charge.max
          ? that.cartTotals.total < charge.max
            ? true
            : false
          : true;

        let amount = condition
          ? charge.percent
            ? (that.cartTotals.total * charge.value) / 100
            : charge.value
          : 0;
        that.methods[index].charges[i].amount = amount;
      });
      return charges;
    },
    methodChargesTotal: function () {
      let that = this;
      return _.round(
        _.reduce(
          that.methodCharges,
          function (sum, item) {
            return sum + item.amount;
          },
          0
        ),
        3
      );
    },
    grandTotal: function () {
      return this.methodChargesTotal + this.cartTotals.total;
    },
  },
  watch: {
    cart: function () {
      this.fetchRCart();
    },
    otp: function () {
      if (this.otp.length == 6) {
        this.otpCode();
      }
    },
    phone: function () {
      this.otpStatus = 0;
      this.errors.phone = "";
    },
    name: function () {
      this.errors.name = "";
    },
    method: function () {
      this.errors.method = "";
    },
    payment: function () {
      this.errors.payment = "";
    },
    addressName: function () {
      this.errors.addressName = "";
    },
    addressRoad: function () {
      this.errors.addressRoad = "";
    },
    addressCity: function () {
      this.addressDistrict = "";
      this.errors.addressCity = "";
    },
    dropoffName: function () {
      this.errors.dropoffName = "";
    },
    dropoffNote: function () {
      this.errors.dropoffNote = "";
    },
    pickupLocation: function () {
      this.errors.pickupLocation = "";
    },
    paymentReceiptName: function () {
      this.errors.paymentReceipt = "";
    },
    paymentChange: function () {
      this.errors.paymentChange = "";
    },
  },
};
</script>

<style>
.form > *:not(:last-child) {
  margin-bottom: 0.5rem !important;
}
h4 {
  font-weight: bold;
}
.tab-contents .content {
  display: block;
}
.tabs.is-toggle.is-danger a {
  border-color: #f14668;
}
.tabs,
.tab-contents {
  margin-bottom: 0.75rem !important;
}
.tab-contents > .content {
  margin-bottom: 0;
}
.item-list > .item {
  padding: 0.75rem 0;
}
.item-list > .item:not(:last-child) {
  border-bottom: 1px solid #eee;
}
.item-list > .item .image img {
  height: 100%;
  object-fit: contain;
}
.media-content h5 {
  margin-bottom: 0.5rem;
}
.media-content h5 a {
  font-size: 0.9em;
}
.cart-total {
  margin: 0.5rem 0;
  font-size: 0.8em;
}
</style>
