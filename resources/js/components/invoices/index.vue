<script setup>
import {ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const invoices = ref([]);
const searchInvoice = ref([]);

onMounted(async () => {
     await getInvoices();
})

const getInvoices = async () => {
    const response = await axios.get('/api/get_all_invoices');
    invoices.value = response.data.invoices;
}

const search = async () => {
    const response = await axios.get(`/api/search_invoice?search=${searchInvoice.value}`);
    invoices.value = response.data.invoices;
}

const newInvoice = async () => {
    const form = await axios.get('/api/create_invoice');
    router.push('/invoice/new');
}

const onShow = (id) => {
    router.push(`/invoice/show/${id}`);
}
</script>

<template>
    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Invoices</h2>
                </div>
                <div>
                    <a class="btn btn-secondary" @click="newInvoice">
                        New Invoice
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="text" placeholder="Search invoice" v-model="searchInvoice" @keyup="search">
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Date</p>
                    <p>Number</p>
                    <p>Customer</p>
                    <p>Due Date</p>
                    <p>Total</p>
                </div>

                <!-- item 1 -->
                <div class="table--items" v-for="(invoice, index) in invoices" :key="index" v-if="invoices.length > 0">
                    <a href="#" class="table--items--transactionId" @click="onShow(invoice.id)">#{{ invoice.id}}</a>
                    <p>{{ invoice.date }}</p>
                    <p>#{{ invoice.number}}</p>
                    <p v-if="invoice.customer">
                        {{ invoice.customer.firstname }}
                    </p>
                    <p v-else></p>
                    <p>{{ invoice.due_date }}</p>
                    <p> $ {{ invoice.total }}</p>
                </div>
                <div class="table--items" v-else>
                    <p>Invoice Not found</p>
                </div>
            </div>

        </div>

        <br><br><br>


<!--        &lt;!&ndash;==================== EDIT INVOICE ====================&ndash;&gt;-->
<!--        <div class="invoices">-->

<!--            <div class="card__header">-->
<!--                <div>-->
<!--                    <h2 class="invoice__title">Edit Invoice</h2>-->
<!--                </div>-->
<!--                <div>-->

<!--                </div>-->
<!--            </div>-->

<!--            <div class="card__content">-->
<!--                <div class="card__content&#45;&#45;header">-->
<!--                    <div>-->
<!--                        <p class="my-1">Customer</p>-->
<!--                        <select name="" id="" class="input">-->
<!--                            <option value="">cust 1</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <p class="my-1">Date</p>-->
<!--                        <input id="date" placeholder="dd-mm-yyyy" type="date" class="input"> &lt;!&ndash;&ndash;&gt;-->
<!--                        <p class="my-1">Due Date</p>-->
<!--                        <input id="due_date" type="date" class="input">-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <p class="my-1">Numero</p>-->
<!--                        <input type="text" class="input">-->
<!--                        <p class="my-1">Reference(Optional)</p>-->
<!--                        <input type="text" class="input">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <br><br>-->
<!--                <div class="table">-->

<!--                    <div class="table&#45;&#45;heading2">-->
<!--                        <p>Item Description</p>-->
<!--                        <p>Unit Price</p>-->
<!--                        <p>Qty</p>-->
<!--                        <p>Total</p>-->
<!--                        <p></p>-->
<!--                    </div>-->

<!--                    &lt;!&ndash; item 1 &ndash;&gt;-->
<!--                    <div class="table&#45;&#45;items2">-->
<!--                        <p>#093654 vjxhchkvhxc vkxckvjkxc jkvjxckvjkx </p>-->
<!--                        <p>-->
<!--                            <input type="text" class="input" >-->
<!--                        </p>-->
<!--                        <p>-->
<!--                            <input type="text" class="input" >-->
<!--                        </p>-->
<!--                        <p>-->
<!--                            $ 10000-->
<!--                        </p>-->
<!--                        <p style="color: red; font-size: 24px;cursor: pointer;">-->
<!--                            &times;-->
<!--                        </p>-->
<!--                    </div>-->
<!--                    <div style="padding: 10px 30px !important;">-->
<!--                        <button class="btn btn-sm btn__open&#45;&#45;modal">Add New Line</button>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="table__footer">-->
<!--                    <div class="document-footer" >-->
<!--                        <p>Terms and Conditions</p>-->
<!--                        <textarea cols="50" rows="7" class="textarea" ></textarea>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <div class="table__footer&#45;&#45;subtotal">-->
<!--                            <p>Sub Total</p>-->
<!--                            <span>$ 1000</span>-->
<!--                        </div>-->
<!--                        <div class="table__footer&#45;&#45;discount">-->
<!--                            <p>Discount</p>-->
<!--                            <input type="text" class="input">-->
<!--                        </div>-->
<!--                        <div class="table__footer&#45;&#45;total">-->
<!--                            <p>Grand Total</p>-->
<!--                            <span>$ 1200</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->


<!--            </div>-->
<!--            <div class="card__header" style="margin-top: 40px;">-->
<!--                <div>-->

<!--                </div>-->
<!--                <div>-->
<!--                    <a class="btn btn-secondary">-->
<!--                        Save-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->

<!--        </div>-->
<!--        &lt;!&ndash;==================== add modal items ====================&ndash;&gt;-->
<!--        <div class="modal main__modal ">-->
<!--            <div class="modal__content">-->
<!--                <span class="modal__close btn__close&#45;&#45;modal">×</span>-->
<!--                <h3 class="modal__title">Add Item</h3>-->
<!--                <hr><br>-->
<!--                <div class="modal__items">-->
<!--                    <select class="input my-1">-->
<!--                        <option value="None">None</option>-->
<!--                        <option value="None">LBC Padala</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                <br><hr>-->
<!--                <div class="model__footer">-->
<!--                    <button class="btn btn-light mr-2 btn__close&#45;&#45;modal">-->
<!--                        Cancel-->
<!--                    </button>-->
<!--                    <button class="btn btn-light btn__close&#45;&#45;modal ">Save</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--        <br><br><br>-->
    </div>
</template>

<style scoped>

</style>
