<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('tenants')">Inquilinos</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :errors="$page.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nome" />
          <text-input v-model="form.last_name" :errors="$page.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Sobrenome" />
          <text-input v-model="form.cpf" :errors="$page.errors.cpf" class="pr-6 pb-8 w-full lg:w-1/2" label="CPF" />
          <text-input v-model="form.rg" :errors="$page.errors.rg" class="pr-6 pb-8 w-full lg:w-1/2" label="RG" />
          <text-input v-model="form.rg_agency_emissor" :errors="$page.errors.rg_agency_emissor" class="pr-6 pb-8 w-full lg:w-1/2" label="Orgão emissor" />
          <text-input v-model="form.rg_agency_state" :errors="$page.errors.rg_agency_state" class="pr-6 pb-8 w-full lg:w-1/2" label="Estado emissor" />
          <!-- <select-input v-model="form.country" :errors="$page.errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input> -->
          <!-- <text-input v-model="form.postal_code" :errors="$page.errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" /> -->
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create Organization</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Create Organization' },
  layout: Layout,
  components: {
    LoadingButton,
    // SelectInput,
    TextInput,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        first_name: null,
        last_name: null,
        cpf: null,
        rg: null,
        rg_agency_emissor: null,
        rg_agency_state: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('tenants.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
