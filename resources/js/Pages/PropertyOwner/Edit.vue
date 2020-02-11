<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('locators')">Locadores</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ locator.first_name }}
    </h1>
    <trashed-message v-if="locator.deleted_at" class="mb-6" @restore="restore">
      Este inquilino foi deletado.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.first_name" :errors="$page.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nome" />
          <text-input v-model="form.last_name" :errors="$page.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Sobrenome" />
          <text-input v-model="form.cpf" :errors="$page.errors.cpf" class="pr-6 pb-8 w-full lg:w-1/2" label="CPF" />
          <text-input v-model="form.rg" :errors="$page.errors.rg" class="pr-6 pb-8 w-full lg:w-1/2" label="RG" />
          <text-input v-model="form.rg_agency_emissor" :errors="$page.errors.rg_agency_emissor" class="pr-6 pb-8 w-full lg:w-1/2" label="Orgão emissor" />
          <text-input v-model="form.rg_agency_state" :errors="$page.errors.rg_agency_state" class="pr-6 pb-8 w-full lg:w-1/2" label="Estado emissor" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!locator.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Deletar inquilio</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Atualizar</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.first_name }
  },
  layout: Layout,
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    locator: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        first_name: this.locator.first_name,
        last_name: this.locator.last_name,
        cpf: this.locator.cpf,
        rg: this.locator.rg,
        rg_agency_emissor: this.locator.rg_agency_emissor,
        rg_agency_state: this.locator.rg_agency_state,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('locators.update', this.locator.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this locator?')) {
        this.$inertia.delete(this.route('locators.destroy', this.locator.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this locator?')) {
        this.$inertia.put(this.route('locators.restore', this.locator.id))
      }
    },
  },
}
</script>
