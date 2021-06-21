<template>
  <div>
    <b-container style="margin-top: 30px">
      <b-row>
        <b-col>
          <b-card title="Product form">
            <b-card-text>
              <b-form @submit="onSubmit" @reset="onReset">
                <b-form-group
                  id="input-group-1"
                  label="Product name:"
                  label-for="product-name"
                >
                  <b-form-input
                    id="product-name"
                    v-model="form.productName"
                    type="text"
                    placeholder="Enter product name"
                    required
                  ></b-form-input>
                </b-form-group>

                <b-form-group
                  id="input-group-2"
                  label="Quantity in stock:"
                  label-for="quantity"
                >
                  <b-form-input
                    id="quantity"
                    v-model="form.quantityInStock"
                    type="number"
                    min="0"
                    placeholder="Enter quantity in stock"
                    required
                  ></b-form-input>
                </b-form-group>

                <b-form-group
                  id="input-group-3"
                  label="Price per item:"
                  label-for="price-per-item"
                >
                  <b-form-input
                    id="price-per-item"
                    v-model="form.pricePerItem"
                    type="number"
                    min="0"
                    step="0.01"
                    placeholder="Enter price per item"
                    required
                  ></b-form-input>
                </b-form-group>

                <b-button type="submit" variant="primary">
                  {{ isCreating ? "Submit" : "Update" }}
                </b-button>
                <b-button type="reset" variant="danger">Reset</b-button>
              </b-form>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
export default {
  props: ["formData"],
  data() {
    return {
      form: this.formData,
    };
  },
  computed: {
    isCreating() {
      return this.form.method === "create";
    },
  },
  methods: {
    onSubmit(event) {
      event.preventDefault();
      if (this.isCreating) {
        this.saveProduct();
      } else {
        this.updateProduct();
      }
    },
    updateProduct() {
      let that = this;
      axios
        .put("/product/" + that.form.id, that.form)
        .then(function (response) {
          that.$emit("updated-product", response.data.product);
        })
        .catch(function (error) {
          if (error.response && error.response.status === 422) {
            if (error.response.data.errors) {
              let errors = error.response.data.errors;
              for (let field of Object.keys(errors)) {
                alert(errors[field][0]);
              }
            }
          } else {
            console.log(error);
          }
        });
    },
    saveProduct() {
      let that = this;
      axios
        .post("/product", that.form)
        .then(function (response) {
          that.$emit("new-product", response.data.product);
        })
        .catch(function (error) {
          if (error.response && error.response.status === 422) {
            if (error.response.data.errors) {
              let errors = error.response.data.errors;
              for (let field of Object.keys(errors)) {
                alert(errors[field][0]);
              }
            }
          } else {
            console.log(error);
          }
        });
    },
    onReset(event) {
      event.preventDefault();
      this.form.id = 0;
      this.form.productName = "";
      this.form.quantityInStock = 0;
      this.form.pricePerItem = 0;
      this.form.method = "create";
    },
  },
};
</script>
