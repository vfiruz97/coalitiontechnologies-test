<template>
  <div>
    <product-form
      :form-data="productFormData"
      @new-product="newProduct"
      @updated-product="updateProductItem"
    ></product-form>
    <div>
      <b-container style="margin-top: 30px">
        <b-row>
          <b-col>
            <b-list-group>
              <b-list-group-item
                variant="primary"
                show
                v-for="product in productList"
                :key="product.id"
              >
                <b>Product name:</b> {{ product.productName }} <b>Quantity in stock:</b>
                {{ product.quantityInStock }} <b>Price per item:</b>
                {{ product.pricePerItem }} <b>DateTime submited:</b>
                {{ product.sendDateTime }} <b>Total value number:</b>
                {{ product.totalValueNumber }}
                <b-button
                  variant="outline-primary"
                  size="sm"
                  @click="updateProduct(product)"
                  >Edit</b-button
                >
              </b-list-group-item>
            </b-list-group>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import ProductForm from "./../Components/ProductForm";

export default {
  props: ["products"],
  data() {
    return {
      productList: this.products,
      productFormData: {
        id: 0,
        productName: "",
        quantityInStock: 0,
        pricePerItem: 0,
        method: "create",
      },
    };
  },
  components: {
    ProductForm,
  },
  methods: {
    updateProduct(product) {
      this.productFormData.id = product.id;
      this.productFormData.productName = product.productName;
      this.productFormData.quantityInStock = product.quantityInStock;
      this.productFormData.pricePerItem = product.pricePerItem;
      this.productFormData.method = "update";
    },
    newProduct(product) {
      this.productList.unshift(product);
      this.onReset();
    },
    updateProductItem(product) {
      for (var i in this.productList) {
        if (this.productList[i].id == product.id) {
          this.productList[i].id = product.id;
          this.productList[i].productName = product.productName;
          this.productList[i].quantityInStock = product.quantityInStock;
          this.productList[i].pricePerItem = product.pricePerItem;
          this.productList[i].sendDateTime = product.sendDateTime;
          this.productList[i].totalValueNumber = product.totalValueNumber;
          break;
        }
      }
      this.onReset();
    },
    onReset() {
      this.productFormData.id = 0;
      this.productFormData.productName = "";
      this.productFormData.quantityInStock = 0;
      this.productFormData.pricePerItem = 0;
      this.productFormData.method = "create";
    },
  },
};
</script>
