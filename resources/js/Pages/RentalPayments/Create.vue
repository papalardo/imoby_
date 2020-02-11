<template>
	<div>
		<h1 class="mb-8 font-bold text-3xl">
			<inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('properties')">Aluguél</inertia-link>
			<span class="text-indigo-400 font-medium">/</span> Pagamento
		</h1>
		<div class="bg-white rounded shadow overflow-hidden max-w-3xl">
			<form @submit.prevent="submit">
				<div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
					<loading-button :loading="sending" class="btn-indigo" type="submit">Firmar pagamento</loading-button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Organization' },
  layout: Layout,
  components: {
    LoadingButton,
  },
  props: {
    month: String,
    year: String,
    contract: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        month_ref: this.month,
        year_ref: this.year,
        contract_id: this.contract.id,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('rental_payment.store', this.contract.id), this.form)
        .then(() => this.sending = false)
    },
  },
}
</script>
