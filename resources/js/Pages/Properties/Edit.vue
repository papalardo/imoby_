<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('properties')">Imóveis</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ property.address }}
    </h1>
    <trashed-message v-if="property.deleted_at" class="mb-6" @restore="restore">
      This property has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.address" :errors="$page.errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Endereço" />
          <text-input v-model="form.ceb_code" :errors="$page.errors.ceb_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Código CEB" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!property.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Deletar imóvel</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Atualizar imóvel</loading-button>
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
    return { title: this.property.address }
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
    property: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        address: this.property.address,
        ceb_code: this.property.ceb_code,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.route('properties.update', this.property.id), this.form)
        .then(() => this.sending = false)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this property?')) {
        this.$inertia.delete(this.route('properties.destroy', this.property.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this property?')) {
        this.$inertia.put(this.route('properties.restore', this.property.id))
      }
    },
  },
}
</script>
