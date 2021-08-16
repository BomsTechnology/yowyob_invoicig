<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div id="dashboard">
        <div class="py-6">
            <x-sub-success />
            <x-myerror />
            <div class="flex justify-between mx-auto sm:px-6 lg:px-8 mb-3">
                <div class="">
                    <form>
                        <span class="absolute mt-2 ml-2"><i class="fa fa-search text-gray-700 "
                                aria-hidden="true"></i></span>
                        <input type="search" v-model="search" placeholder="Search bill" name="search"
                            class="border-gray-700 pl-8 px-0 placeholder-gray-700 rounded-md bg-transparent  focus:border-gray-900 focus:ring-gray-900 outline-none focus:outline-none text-gray-700">
                    </form>
                </div>
                <div>
                    <a href="{{ route('facture.index') }}"
                        class="bg-blue-500 text-white tracking-widest p-2 rounded shadow-md flex ">
                        <span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span class="ml-2">
                            Nouvelle Facture
                        </span>
                    </a>
                </div>
            </div>
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Customer
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                State
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tva
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-if="(search != '' && filteredCustomer.length == 1) || (search == '') "
                                            v-for="bill in filteredBill" :key="bill.id">
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <span v-for="customer in customers">
                                                        <span v-if="customer.id === bill.key.customerId">
                                                            @{{ customer . name }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @{{ bill . date }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                <span v-if="bill.state_bill"
                                                    class="p-1 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Valide
                                                </span>
                                                <span v-else
                                                    class="p-1 inline-flex leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Annulé
                                                </span>
                                                -
                                                <span v-if="bill.state_payment"
                                                    class="p-1 inline-flex leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    payé
                                                </span>
                                                <span v-else
                                                    class="p-1 inline-flex leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    non payé
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @{{ bill . tva }} %
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                @{{ bill . amount }} XFA
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium flex">
                                                <div class="px-1">
                                                    <button @click="details(bill.key.billId, bill.key.customerId)"
                                                        class="bg-indigo-100 rounded text-indigo-600 hover:text-indigo-900 px-1">Details</a>
                                                </div>


                                                <div class="px-1">
                                                    <button @click="showPay(bill.key.billId, bill.key.customerId)" v-if="!bill.state_payment"
                                                        class="text-blue-600 hover:text-blue-900 bg-blue-100 px-1 rounded">Payé</button>
                                                </div>

                                                <div class="inline-block px-1">
                                                    <button @click="showDel(bill.key.billId, bill.key.customerId)" v-if="bill.state_bill"
                                                        class="text-red-600 hover:text-red-900 bg-red-100 rounded">Annulé
                                                        Facture</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="search != '' && filteredCustomer.length > 1">
                                            <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-center"
                                                colspan="6">
                                                <span class="text-center ">
                                                    <svg class="animate-spin w-10 h-10 text-blue-500 inline-block"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4335 4335">
                                                        <path fill="#008DD2"
                                                            d="M3346 1077c41,0 75,34 75,75 0,41 -34,75 -75,75 -41,0 -75,-34 -75,-75 0,-41 34,-75 75,-75zm-1198 -824c193,0 349,156 349,349 0,193 -156,349 -349,349 -193,0 -349,-156 -349,-349 0,-193 156,-349 349,-349zm-1116 546c151,0 274,123 274,274 0,151 -123,274 -274,274 -151,0 -274,-123 -274,-274 0,-151 123,-274 274,-274zm-500 1189c134,0 243,109 243,243 0,134 -109,243 -243,243 -134,0 -243,-109 -243,-243 0,-134 109,-243 243,-243zm500 1223c121,0 218,98 218,218 0,121 -98,218 -218,218 -121,0 -218,-98 -218,-218 0,-121 98,-218 218,-218zm1116 434c110,0 200,89 200,200 0,110 -89,200 -200,200 -110,0 -200,-89 -200,-200 0,-110 89,-200 200,-200zm1145 -434c81,0 147,66 147,147 0,81 -66,147 -147,147 -81,0 -147,-66 -147,-147 0,-81 66,-147 147,-147zm459 -1098c65,0 119,53 119,119 0,65 -53,119 -119,119 -65,0 -119,-53 -119,-119 0,-65 53,-119 119,-119z" />
                                                    </svg>
                                                    <span class="ml-2 text-lg font-semibold text-blue-400">
                                                        Searching
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>

                                        <tr
                                            v-if="(filteredCustomer.length == 0) || filteredCustomer.length > 0 && filteredBill.length == []">
                                            <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-center"
                                                colspan="6">
                                                <span class="text-blue-600 text-center ">Not Bills</span>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-center"
                                                colspan="4">
                                                Total
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-left"
                                                colspan="2">
                                                @{{ total }} XFA
                                            </td>
                                        </tr>
                                        <x-pay-alert @:pay="pay">
                                        </x-pay-alert>
                                    </tbody>
                                    <x-delete-alert @:show="show">
                                    </x-delete-alert>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    bills: {!! json_encode($bills) !!},
                    customers: {!! json_encode($customers) !!},
                    search: '',
                    show: false,
                    pay: false,
                    route: '',
                    pass: '',
                    selected: {
                        bill: '',
                        customer: '',
                    }
                }
            },
            computed: {
                total() {
                    total = 0;
                    this.filteredBill.forEach(bill => {
                        total += bill.amount
                    });
                    if (this.search != '' && this.filteredCustomer.length > 1) {
                        return 0;
                    }
                    else {
                        return total;
                    }
                },
                filteredCustomer() {
                    return this.customers.filter((customer) => {
                        return customer.name.toLowerCase().includes(this.search.toLowerCase());
                    })
                },
                filteredBill() {
                    if (this.search != '') {
                        if (this.filteredCustomer.length > 0) {
                            return this.bills.filter((bill) => {
                                return bill.key.customerId.includes(this.filteredCustomer[0].id);
                            })
                        } else {
                            return [];
                        }
                    } else {
                        return this.bills;
                    }
                },

            },
            methods: {
                paying() {
                    window.location = "/pay/"+this.selected.bill+"/"+this.selected.customer;
                },
                details(bill, customer) {
                    window.location = "/details/"+bill+"/"+customer;
                },
                showPay(bill, customer) {
                    this.selected.bill = bill;
                    this.selected.customer = customer;
                    this.pay = true;
                },
                showDel(bill, customer) {
                    this.selected.bill = bill;
                    this.selected.customer = customer;
                    this.show = true;
                },
                deleting() {
                    window.location = "/delete/"+this.selected.bill+"/"+this.selected.customer+"/"+this.pass;
                }
            },
        }
        Vue.createApp(app).mount('#dashboard')
    </script>
</x-app-layout>
