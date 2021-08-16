<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Facture') }}
        </h2>
    </x-slot>
    <div id="facture">
        {{-- start error --}}
        <div class="alert flex flex-row items-center bg-red-200 p-5 rounded border-b-2 border-red-300 my-5 mb-4"
            v-if="terror">
            <div
                class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                <span class="text-red-500">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            <div class="alert-content ml-4">
                <div class="alert-title font-semibold text-lg text-red-800">
                    La facture ne peut pas être enregistrer, verifier si toutes les informations sont remplis
                </div>
            </div>
        </div>
        {{-- end error --}}
        <div class="mt-4 mx-8 bg-white grid lg:grid-cols-2 gap-2 rounded-md shadow-md h-div">
            <div class="rounded-none px-9 py-4 rounded-l-md h-div overflow-x-auto">
                <div class="mb-4 text-2xl font-semibold tracking-widest flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-500 text-white tracking-widest p-1 px-2 rounded shadow-md flex items-center">
                            <span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="ml-2">
                                Home
                            </span>
                        </a>
                    </div>
                    <div>
                        <h2>
                            Liste des produits
                        </h2>
                    </div>
                </div>
                <div class="w-full mb-4 flex items-center justify-between">
                    <div class="relative flex-1 w-full">
                        <span class="absolute mt-3 ml-2 text-sm"><i class="fa fa-search text-gray-700 "
                                aria-hidden="true"></i></span>
                        <input type="search" name="search" v-model="searchKey" placeholder="search product"
                            class="rounded pl-8 placeholder-gray-700 ">
                    </div>
                    <div class="flex text-gray-700">
                        <span class="p-2 rounded cursor-pointer" :class="{'bg-blue-200' :  active}" @click="viewList">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <span @click="viewCard" class="p-2 rounded cursor-pointer" :class="{'bg-blue-200' :  !active}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" :class="{'hidden' :  active}">
                    <div class="shadow-lg rounded-lg border border-gray-50" v-if="filteredList.length  != []"
                        v-for="product in filteredList" :key="product.id">
                        <div class="px-3 py-1 text-center">
                            <h1 class="text-gray-900 font-bold text-lg">
                                @{{ product . name }}
                            </h1>
                        </div>
                        <div>
                            <img src="{{ asset('open-parcel.png') }}" alt="" class="object-cover">
                        </div>
                        <div class="px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-700 cursor-pointer"
                            @click="viewInput(product.id)">
                            <div>
                                <h1 class="text-gray-200 font-bold text-sm">
                                    @{{ product . price }} XFA
                                </h1>
                            </div>
                            <div class="flex items-center justify-between"
                                v-if="showInput.id == product.id && showInput.state == true">
                                <input type="number" name="" id="" class="px-2 py-0 w-20 rounded-md" v-model="nb">
                                <button @click="saveProduct(product)"
                                    class="px-2 py-1 bg-gray-200 text-xs text-gray-900 font-semibold rounded">Add to
                                    card</button>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <span class="text-center text-gray-500">No products</span>
                    </div>
                </div>
                <div class="flex-col" :class="{'flex' :  active, 'hidden' : !active}">
                    <div class="-my-2 sm:-mx-6 lg:-mx-8 mx-2">
                        <div class="py-2 align-middle inline-block min-w-full px-1">
                            <div class="shadow border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nom
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Prix
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                            </th>
                                            <th scope="col"
                                                class="px-4 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                        <tr v-if="filteredList.length  != []" v-for="product in filteredList"
                                            :key="product.id" class="cursor-pointer hover:bg-gray-50"
                                            @click="viewInput(product.id)">
                                            <td class="p-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @{{ product . name }}
                                                </div>
                                            </td>
                                            <td class="p-2 whitespace-nowrap text-sm text-gray-500">
                                                <div class="text-sm font-medium text-gray-900">
                                                    @{{ product . price }} XFA
                                                </div>
                                            </td>
                                            <td class="p-2 whitespace-nowrap text-sm text-gray-500">
                                                <div class="text-sm font-medium text-gray-900"
                                                    v-if="showInput.id == product.id && showInput.state == true">
                                                    <input type="number" name="" id="" class="px-2 py-0 w-32 rounded-md"
                                                        v-model="nb">
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 whitespace-nowrap text-right text-sm font-medium border-l-2 border-gray-200">
                                                <button @click="saveProduct(product)" type="button"
                                                    class="text-blue-600 hover:text-blue-900"><svg class="w-6 h-6"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg></button>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td class="text-center text-gray-500">No products</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-none rounded-r-md px-2 py-4 h-div">
                <div class="text-2xl font-semibold tracking-widest">
                    <h2>Informations de la facture</h2>
                </div>
                <div class="mt-4 md:mt-0 md:col-span-2">
                    <div class="shadow overflow-hidden sm:rounded-md h-full">
                        <div class="px-4 py-2 bg-white sm:p-6">
                            <div class="col-span-6 sm:col-span-3 mb-3 relative">
                                <label for="country" class="block text-sm font-medium text-gray-700">Nom du
                                    client</label>
                                <input type="text" v-model="searchCustomer"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <div class="bg-gray-50 border border-gray-100 shadow-md rounded-md w-full absolute"
                                    v-if="searchCustomer  != ''">
                                    <ul>
                                        <li v-for="customer in filteredCustomer" @click="selectCustomer(customer)"
                                            class="p-2 border-b border-gray-300 text-sm cursor-pointer text-gray-500 hover:bg-gray-200 hover:text-gray-600">
                                            @{{ customer . name + ' ' + customer . fisrtname }}
                                        </li>
                                    </ul>
                                </div>
                                <div v-else class="hidden">
                                    @{{ auser = true }}
                                </div>
                                <div class="bg-gray-50 border border-gray-100 shadow-md rounded-md w-full absolute"
                                    v-if="searchCustomer  != '' && filteredCustomer.length == [] && auser">
                                    <ul>
                                        <li class="p-2 border-b border-gray-300 text-sm cursor-pointer text-gray-500 hover:bg-gray-200 hover:text-gray-600"
                                            @click="showUser">
                                            Ajouter le client << @{{ searchCustomer }}>>
                                        </li>
                                        <x-add-user-alert @:user="user">
                                        </x-add-user-alert>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-span-6 sm:col-span-4 mb-3">
                                <label for="" class="block text-sm font-medium text-gray-700 mb-4">
                                    Liste des produits
                                </label>
                                <div class="col-span-6 h-72">
                                    <div class="flex flex-col w-full h-full">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-1 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <div
                                                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <tr v-if="listProduct.length  != []"
                                                                v-for="p in mListProduct" :key="p.product.id"
                                                                class="cursor-pointer hover:bg-gray-50"
                                                                @click="showChange(p.product.id)">
                                                                <td class="px-4 py-2 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <div class="ml-4">
                                                                            <div
                                                                                class="text-sm font-medium text-gray-900">
                                                                                @{{ p . product . name }}
                                                                            </div>
                                                                            <div class="text-sm text-gray-500">
                                                                                PU : @{{ p . product . price }} X F A
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td
                                                                    class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                                                    QTE : @{{ p . qte }}
                                                                    <span class="ml-2  hover:text-gray-700 flex"
                                                                        v-if="showChangeInput.id == p.product.id && showChangeInput.state == true">
                                                                        <input type="number" name="" id=""
                                                                            class="px-2 py-0 w-20 rounded-md"
                                                                            v-model="nb">
                                                                        <svg @click="changeQte(p)"
                                                                            class="ml-2 w-5 h-5 cursor-pointer"
                                                                            fill="currentColor" viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                </td>
                                                                <td
                                                                    class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                                    @{{ parseInt(p . product . price) * parseInt(p . qte) }}
                                                                    X F A
                                                                </td>
                                                                <td
                                                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                    <a href="#" @click.prevent="removeProduct(p)"
                                                                        class="text-red-600 hover:text-red-900">Remove</a>
                                                                </td>
                                                            </tr>
                                                            <tr v-else>
                                                                <td class="text-gray-500 text-center">No Product</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-3 lg:col-span-2 grid justify-items-end">
                                    <div class="mt-2 flex">
                                        <div>
                                            <h1 class="font-bold">MHT :</h1>
                                            <input type="text" v-model="tMontant.mht" readonly
                                                class="w-full shadow-sm sm:text-sm border-none rounded-md">
                                        </div>
                                        <div class="ml-4">
                                            <span class="flex items-center">
                                                <input type="checkbox" name="" id="" v-model="checkTva">
                                                <h1 class="font-bold ml-2">TVA(@{{ tMontant . tauxTVA }} %):</h1>
                                                {{-- <svg v-if="checkTva"
                                                    class="w-5 h-5 hover:text-gray-700 cursor-pointer ml-1"
                                                    fill="currentColor" @click="showTaux" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                                <x-update-taux-alert @:tva="tva">
                                                </x-update-taux-alert> --}}
                                            </span>
                                            <input type="text" v-model="tMontant.taxe" readonly
                                                class="w-full shadow-sm sm:text-sm border-none rounded-md">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <h1 class="font-bold">MTTC :</h1>
                                        <input type="text" v-model="tMontant.mttc" readonly
                                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-gray-50 text-right sm:px-6">
                            <a href="#" @click="save"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enregistrer
                            </a>
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
                    products: {!! json_encode($products) !!},
                    customers: {!! json_encode($customers) !!},
                    customerActif: {
                        id: '',
                        name: '',
                        fisrtname: '',
                        contact: '',
                    },
                    listProduct: [],
                    montant: {
                        mht: 0,
                        tauxTVA: 19.25,
                        taxe: 0,
                        mttc: 0,
                    },
                    showInput: {
                        id: '',
                        state: false
                    },
                    showChangeInput: {
                        id: '',
                        state: false
                    },
                    active: true,
                    checkTva: true,
                    searchKey: '',
                    searchCustomer: '',
                    nb: '',
                    cqte: '',
                    user: false,
                    error: false,
                    auser: false,
                    terror: false,
                }
            },
            computed: {
                filteredList() {
                    return this.products.filter((product) => {
                        return product.name.toLowerCase().includes(this.searchKey.toLowerCase());
                    })
                },
                filteredCustomer() {
                    return this.customers.filter((customer) => {
                        return customer.name.toLowerCase().includes(this.searchCustomer.toLowerCase());
                    })
                },
                tMontant() {
                    this.montant.mht = 0;
                    this.montant.taxe = 0;
                    this.montant.mttc = 0;
                    this.terror = false;
                    this.listProduct.forEach((item, index, arr) => {
                        this.montant.mht += parseInt(item.product.price) * parseInt(item.qte);
                    });
                    if (!this.checkTva) {
                        this.montant.tauxTVA = 0;
                        this.montant.taxe = 0;
                    } else {
                        this.montant.taxe = (this.montant.mht * this.montant.tauxTVA) / 100;
                        this.montant.tauxTVA = 19.25;
                    }
                    this.montant.mttc = this.montant.mht + this.montant.taxe;
                    return this.montant;
                },
                mListProduct() {
                    return this.listProduct;
                },
            },
            methods: {
                viewCard() {
                    this.active = false;
                },
                viewList() {
                    this.active = true;
                },
                showChange(id) {
                    this.showChangeInput.id = id;
                    this.showChangeInput.state = true;
                },
                showTaux() {
                    this.tva = !this.tva;
                    this.nb = this.montant.tauxTVA;
                },
                showUser() {
                    this.user = !this.user;
                    this.customerActif.name = this.searchCustomer;
                },
                saveProduct(product) {
                    if (this.nb == '') {
                        this.viewInput(product.id)
                    } else {
                        for (let i = 0; i < this.listProduct.length; i++) {
                            if (this.listProduct[i].product.id === product.id) {
                                this.qte = !this.qte;
                                return this.listProduct[i].qte = parseInt(this.listProduct[i].qte) + parseInt(this.nb);
                                this.nb = '';
                            }

                        }
                        p = {
                            'product': product,
                            'qte': this.nb
                        };
                        this.listProduct.push(p);
                        this.nb = '';
                    }
                },
                changeQte(p) {
                    this.listProduct.forEach((item, index, arr) => {
                        if (item.product.id == p.product.id) {
                            item.qte = this.nb;
                        }
                    });
                    this.nb = '';
                    this.showChangeInput.id = '';
                    this.showChangeInput.state = false;
                },
                changeTaux() {
                    this.montant.tauxTVA = this.nb;
                    this.tva = !this.tva;
                },
                selectCustomer(customer) {
                    this.customerActif = customer;
                    this.searchCustomer = customer.name + ' ' + customer.fisrtname;
                    this.auser = false;
                    this.terror = false;
                },
                createCustomer() {
                    if (this.customerActif.name == '' || this.customerActif.fisrtname == '' || this.customerActif
                        .contact == '') {
                        this.error = true;
                    } else {
                        this.user = !this.user;
                        this.auser = false;
                        this.terror = false;
                        this.searchCustomer = this.customerActif.name + ' ' + this.customerActif.fisrtname;
                    }
                },
                removeProduct(p) {
                    index = this.listProduct.indexOf(p);
                    this.listProduct.splice(index, 1);
                },
                viewInput(id) {
                    this.showInput.id = id;
                    this.showInput.state = true;
                },
                save() {
                    tab = [];
                    this.listProduct.forEach((item, index, arr) => {
                        t = [
                            item.product.id,
                            item.product.name,
                            item.product.price,
                            item.qte,
                        ];
                        tab.push(t)
                    });

                    m = [
                        this.montant.tauxTVA,
                        this.montant.mttc
                    ];

                    c = [
                        this.customerActif.id,
                        this.customerActif.name,
                        this.customerActif.fisrtname,
                        this.customerActif.contact,

                    ];

                    if (tab.length == [] || this.customerActif.name == '') {
                        this.terror = true;
                    } else {
                        window.location = "/save/" + tab + "/" + c + "/" + m;
                    }
                }
            },
        }
        Vue.createApp(app).mount('#facture')
    </script>
</x-app-layout>
