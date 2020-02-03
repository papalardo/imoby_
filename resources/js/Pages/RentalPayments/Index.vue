<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
      Pagamentos de Aluguéis
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.year || new Date().getFullYear() }}
      <span
        class="text-indigo-400 font-medium"
      >/</span>
      {{ getMonth(form.month || (new Date().getMonth())) | capitalize }}
    </h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Mês de referência:</label>
        <select v-model="form.month" class="mt-1 w-full form-select">
          <option v-for="i in 12" :key="i" :value="i">{{ getMonth(i) | capitalize }}</option>
        </select>
        <label class="block text-gray-700 mt-4">Ano de referência:</label>
        <select v-model="form.year" class="mt-1 w-full form-select">
          <option v-for="i in 3" :key="i" :value="(2022 - i)">{{ 2022 - i }}</option>
        </select>
      </search-filter>
      <div class="btn-indigo" :href="route('contracts.create')">
        <span>Create</span>
        <span class="hidden md:inline">contract</span>
      </div>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Inquilino</th>
          <th class="px-6 pt-6 pb-4">Imóvel</th>
          <th class="px-6 pt-6 pb-4">Vencimento</th>
          <th class="px-6 pt-6 pb-4">Status</th>
          <th class="px-6 pt-6 pb-4">Ações</th>
        </tr>
        <tr
          v-for="contract in payments.data"
          :key="contract.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="border-t">
            <div
              class="px-6 py-4 flex items-center"
              tabindex="-1"
            >
              {{ contract.tenant }}
            </div>
          </td>
          <td class="border-t">
            <div
              class="px-6 py-4 flex items-center"
              tabindex="-1"
            >
              {{ contract.property }}
            </div>
          </td>
          <td class="border-t">
            <div
              class="px-6 py-4 flex items-center focus:text-indigo-500"
            >
              {{ contract.due_date }}
              <icon
                v-if="contract.deleted_at"
                name="trash"
                class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2"
              />
            </div>
          </td>
          <td class="border-t">
            <div
              class="px-6 py-4 flex items-center focus:text-indigo-500"
              :style="{ 'color': contract.payable == 'Atrasado' ? 'red' : null }"
            >
              {{ contract.payable }}
            </div>
          </td>
          <td class="border-t w-px">
            <inertia-link
              method="put"
              class="px-4 flex items-center"
              :data="{ paid: !contract.paid }"
              :href="route('rental_payment.update', contract.id)"
              tabindex="-1"
            >
              <input type="checkbox" :checked="contract.paid"/>
            </inertia-link>
          </td>
        </tr>
        <tr v-if="payments.data.length === 0">
          <td class="border-t px-6 py-4 text-align" colspan="5">Nenhum registro encontrado.</td>
        </tr>
      </table>
    </div>
    <pagination :links="payments.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Shared/SearchFilter'
import throttle from 'lodash/throttle'

export default {
    metaInfo: { title: 'contracts' },
    layout: Layout,
    components: {
        Icon,
        Pagination,
        SearchFilter,
    },
    filters: {
        capitalize(s) {
            if (typeof s !== 'string') return ''
            return s.charAt(0).toUpperCase() + s.slice(1)
        },
    },
    props: {
        payments: Object,
        filters: Object,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
                month: this.filters.month,
                year: this.filters.year,
            },
        }
    },
    watch: {
        form: {
            handler: throttle(function() {
                let query = pickBy(this.form)
                this.$inertia.replace(
                    this.route(
                        'rental_payment',
                        Object.keys(query).length
                            ? query
                            : { remember: 'forget' }
                    )
                )
            }, 150),
            deep: true,
        },
    },
    methods: {
        reset() {
            this.form = mapValues(this.form, () => null)
        },
        getMonth(idx) {
            var objDate = new Date()
            objDate.setDate(1)
            objDate.setMonth(idx - 1)

            var locale = 'pt-BR',
                month = objDate.toLocaleString(locale, { month: 'long' })

            return month
        },
    },
}
</script>
