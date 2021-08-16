const app = {
    data() {
        return {
            products: {!!json_encode($products) !! },
            customers: {!!json_encode($customers) !! },
            productActif: {},
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
            active: true,
            searchKey: '',
            searchCustomer: '',
            nb: '',
            cqte: '',
            qte: false,
            change: false,
            tva: false,
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
            this.montant.taxe = (this.montant.mht * this.montant.tauxTVA) / 100;
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
        showQte(id) {
            this.products.forEach((item, index, arr) => {
                if (item.id == id) {
                    this.productActif = item;
                }
            });
            this.qte = !this.qte
        },
        showChange(id) {
            this.listProduct.forEach((item, index, arr) => {
                if (item.product.id == id) {
                    this.productActif = item;
                    this.nb = item.qte;
                }
            });
            this.change = !this.change;
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
            this.qte = !this.qte;
        },
        changeQte(p) {
            this.listProduct.forEach((item, index, arr) => {
                if (item.product.id == p.product.id) {
                    item.qte = this.nb;
                }
            });
            this.nb = '';
            this.change = !this.change;
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