<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('contracts')">contracts</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
         <select-input v-model="form.locator_id" :errors="$page.errors.locator_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Locatário">
            <option :value="null" />
            <option v-for="locator in locators" :key="locator.id" :value="locator.id">{{ locator.first_name }}</option>
          </select-input>
          <select-input v-model="form.property_id" :errors="$page.errors.property_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Imóvel">
            <option :value="null" />
            <option v-for="property in properties" :key="property.id" :value="property.id">{{ property.address }}</option>
          </select-input>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <label class="form-label">Data início:</label>
            <date-picker
              v-model="date_begin"
              date="YYYY-MM-DD"
              :locale="{ id: 'pt-BR', firstDayOfWeek: 2 }"
              :min-date="new Date()"
            />
          </div>
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
import Vue from 'vue';
import DatePicker from 'v-calendar/lib/components/date-picker.umd'

export default {
  metaInfo: { title: 'Create Organization' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    // TextInput,
    DatePicker,
  },
  remember: 'form',
  props: {
    locators: Array,
    properties: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        locator_id: null,
        property_id: null,
        date_begin: null,
      },
      date_begin: null,
    }
  },
  watch: {
    date_begin(date) {
      this.form.date_begin = date ? new Date(date).toISOString().substring(0, 10) : null
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('contracts.store'), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
