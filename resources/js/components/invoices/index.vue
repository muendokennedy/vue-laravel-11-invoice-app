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




<!--        <br><br><br>-->
    </div>
</template>

<style scoped>

</style>
