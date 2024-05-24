<script setup>
// import {ref, onMounted} from "vue";
// import axios from "axios";
// import router from "@/Router/index.js";
//
// const form = ref([]);
// const allCustomers = ref([]);
// let listCart = ref([]);
// const showModal = ref(false);
// let listProducts = ref([]);
//
//
// onMounted(async () => {
//     await indexForm();
//     await getAllCustomers();
//     await getProducts();
// })
//
//
// const indexForm = async () => {
//     const response = await axios.get('/api/create_invoice');
//     form.value = response.data;
// }
//

//
// const addCart = (item) => {
//     const itemCart = {
//         id: item.id,
//         item_code: item.item_code,
//         description: item.description,
//         unit_price: item.unit_price,
//         quantity: form.value.items[0].quantity
//     }
//
//     let existingItemId;
//
//     listCart.value.map(data => {
//         if(data.id === item.id){
//             existingItemId = item.id;
//         }
//     })
//
//     if(existingItemId !== item.id){
//         listCart.value.push(itemCart);
//         toggleModal();
//     } else{
//         alert('product already added')
//     }
//
// }
//

//
// const getProducts = async () => {
//     let response = await axios.get('/api/products');
//     listProducts.value = response.data.products;
// }
//
// const removeItem = (id) => {
//     listCart.value = listCart.value.filter(item => item.id !== id);
// }
//

//
// const onSave = () => {
//     if(listCart.value.length >= 1){
//         let subtotal = 0;
//         subtotal = subTotal();
//         let total = 0;
//         total = grandTotal();
//
//         const formData = new FormData();
//
//         formData.append('invoice_item', JSON.stringify(listCart.value));
//         formData.append('customer_id', form.value.customer_id);
//         formData.append('date', form.value.date);
//         formData.append('due_date', form.value.due_date);
//         formData.append('number', form.value.number);
//         formData.append('reference', form.value.reference);
//         formData.append('discount', form.value.discount);
//         formData.append('subtotal', total);
//         formData.append('total', subtotal);
//         formData.append('terms_and_conditions', form.value.terms_and_conditions);
//
//         axios.post('/api/add_invoice', formData);
//
//         listCart.value = [];
//
//         router.push('/');
//
//     }
// }
import {onMounted, ref} from "vue";
import axios from "axios";

const props = defineProps({
    id: {
        type: String,
        required: true,
    }
});

const allCustomers = ref([]);

const form = ref([]);
let listCart = ref([]);
const showModal = ref(false);
let listProducts = ref([]);

onMounted(async () => {
    await getInvoice();
    await getAllCustomers();
    await getProducts();
})



const getInvoice = async () => {
    const response = await axios.get(`/api/edit_invoice/${props.id}`);
    form.value = response.data.invoice;
}

const getAllCustomers = async () => {
    const response = await axios.get('/api/customers');

    allCustomers.value = response.data.customers;
}

const toggleModal = () => {
    showModal.value = !showModal.value;
}

const addCart = (item) => {
    const itemCart = {
        product_id: item.id,
        item_code: item.item_code,
        description: item.description,
        unit_price: item.unit_price,
        quantity: form.value.items[0].quantity
    }

    let existingItemId;

    form.value.invoice_items.map(data => {
        if(data.id === item.id){
            existingItemId = item.id;
        }
    })

    if(existingItemId !== item.id){
        form.value.invoice_items.push(itemCart);
        toggleModal();
    } else{
        alert('product already added')
    }

}

const deleteInvoiceItems = (id, i) => {

    form.value.invoice_items.splice(i, 1);

    if(id !== undefined){
        axios.get(`/api/delete_invoice_item/${id}`);
    }
}

const removeItem = (id) => {
    listCart.value = listCart.value.filter(item => item.id !== id);
}

const getProducts = async () => {
    let response = await axios.get('/api/products');
    listProducts.value = response.data.products;
}

const subTotal = () => {
    let total = 0;
    listCart.value.map((data) => {
        total = total + (data.quantity * data.unit_price);
    })

    return total;
}

const grandTotal = () => {
    return subTotal() - form.value.discount;
}

</script>

<template>
  <div class="container">
              <!--==================== EDIT INVOICE ====================-->
              <div class="invoices">

                  <div class="card__header">
                      <div>
                          <h2 class="invoice__title">Edit Invoice</h2>
                      </div>
                      <div>

                      </div>
                  </div>

                  <div class="card__content">
                      <div class="card__content--header">
                          <div>
                              <p class="my-1">Customer</p>
                              <select name="" id="" class="input" v-model="form.customer_id">
                                  <option disabled>Select Customer</option>
                                  <option v-for="(customer, index) in allCustomers" :key="index" :value="customer.id">
                                      {{ customer.firstname }}
                                  </option>
                              </select>
                          </div>
                          <div>
                              <p class="my-1">Date</p>
                              <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="form.date"> <!---->
                              <p class="my-1">Due Date</p>
                              <input id="due_date" type="date" class="input" v-model="form.date">
                          </div>
                          <div>
                              <p class="my-1">Numero</p>
                              <input type="text" class="input" v-model="form.data">
                              <p class="my-1">Reference(Optional)</p>
                              <input type="text" class="input" v-model="form.reference">
                          </div>
                      </div>
                      <br><br>
                      <div class="table">

                          <div class="table--heading2">
                              <p>Item Description</p>
                              <p>Unit Price</p>
                              <p>Qty</p>
                              <p>Total</p>
                              <p></p>
                          </div>

                          <!-- item 1 -->
                          <div class="table--items2" v-for="(itemCart, index) in form.invoice_items" :key="index">
                              <p v-if="itemCart.product">
                                  #{{ itemCart.product.item_code }} {{ itemCart.product.description }}
                              </p>
                              <p>
                                  <input type="text" class="input" v-model="itemCart.unit_price">
                              </p>
                              <p>
                                  <input type="text" class="input" v-model="itemCart.quantity">
                              </p>
                              <p v-if="itemCart.quantity">
                                  $ {{ (itemCart.quantity) * (itemCart.unit_price) }}
                              </p>
                              <p v-else></p>
                              <p style="color: red; font-size: 24px;cursor: pointer;" @click="deleteInvoiceItems(itemCart.id, index)">
                                  &times;
                              </p>
                          </div>
                          <div style="padding: 10px 30px !important;">
                              <button class="btn btn-sm btn__open--modal" @click="toggleModal">Add New Line</button>
                          </div>
                      </div>

                      <div class="table__footer">
                          <div class="document-footer" >
                              <p>Terms and Conditions</p>
                              <textarea cols="50" rows="7" class="textarea" ></textarea>
                          </div>
                          <div>
                              <div class="table__footer--subtotal">
                                  <p>Sub Total</p>
                                  <span>$ {{ subTotal()}}</span>
                              </div>
                              <div class="table__footer--discount">
                                  <p>Discount</p>
                                  <input type="text" class="input" v-model="form.discount">
                              </div>
                              <div class="table__footer--total">
                                  <p>Grand Total</p>
                                  <span>$ {{ grandTotal() }}</span>
                              </div>
                          </div>
                      </div>


                  </div>
                  <div class="card__header" style="margin-top: 40px;">
                      <div>

                      </div>
                      <div>
                          <a class="btn btn-secondary">
                              Save
                          </a>
                      </div>
                  </div>

              </div>
              <!--==================== add modal items ====================-->
      <div class="modal main__modal " :class="{show: showModal}">
          <div class="modal__content">
              <span class="modal__close btn__close--modal" @click="toggleModal">×</span>
              <h3 class="modal__title">Add Item</h3>
              <hr><br>
              <div class="modal__items">
                  <ul style="list-style: none;">
                      <li v-for="(product, index) in listProducts" :key="index" style="display: grid; grid-template-columns: 30px 350px 15px; align-items: center; padding-bottom: 5px;">
                          <p>{{ index + 1}}</p>
                          <a href="#">{{ product.item_code}} {{ product.description }}</a>
                          <button @click="addCart(product)" style="border: 1px solid #e0e0e0; width: 35px; height: 35px; cursor: pointer;">+</button>
                      </li>
                  </ul>
              </div>
              <br><hr>
              <div class="model__footer">
                  <button class="btn btn-light mr-2 btn__close--modal" @click="toggleModal">
                      Cancel
                  </button>
                  <button class="btn btn-light btn__close--modal ">Save</button>
              </div>
          </div>
      </div>
  </div>
</template>

<style scoped>

</style>
