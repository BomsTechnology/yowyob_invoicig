<div v-if="user" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 sm:mx-0 sm:h-10 sm:w-10">
                <span><i class="fa fa-cart-plus text-blue-700 text-2xl" aria-hidden="true"></i>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                Ajouter Client
                {{-- start error --}}
                <div class="alert flex flex-row items-center bg-red-200 py-1 px-2 rounded border-b-2 border-red-300 my-5 mb-4" v-if="error">
                    <div class="alert-icon flex items-center bg-red-100 border-2 border-red-500 justify-center h-8 w-8 flex-shrink-0 rounded-full">
                            <span class="text-red-500">
                                <svg fill="currentColor"
                                     viewBox="0 0 20 20"
                                     class="h-4 w-4">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </span>
                    </div>
                    <div class="alert-content ml-4">
                        <div class="alert-title font-semibold text-xs text-red-800">
                            Veillez remplir tous les champs ...
                        </div>
                    </div>
                </div>
                {{-- end error --}}
                <div class="mt-2">
                    <p class="whitespace-normal text-sm text-gray-500">
                        <input type="text" v-model="customerActif.name" placeholder="Nom" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </p>
                </div>
                <div class="mt-2">
                    <p class="whitespace-normal text-sm text-gray-500">
                        <input type="text" v-model="customerActif.fisrtname" placeholder="Prenom" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </p>
                </div>
                <div class="mt-2">
                    <p class="whitespace-normal text-sm text-gray-500">
                        <input type="text" v-model="customerActif.contact" placeholder="Contact" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </p>
                </div>
            </div>
            </div>
        </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="createCustomer"  type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                OK
            </button>
            <button @click="showUser" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Cancel
            </button>
            </div>
      </div>
    </div>
  </div>
