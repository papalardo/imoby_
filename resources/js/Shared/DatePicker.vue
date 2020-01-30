<template>
  <div>
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <date-picker
        :value="localValue"
        @input="value => $emit('input', formatDate(value))"
        :locale="{ id: 'pt-BR', firstDayOfWeek: 2 }"
        :min-date="new Date()"
    />
    <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
  </div>
</template>

<script>
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
export default {
    components: {
        DatePicker
    },
    props: {
        value: String,
        label: String,
        errors: {
            type: Array,
            default: () => [],
        },
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`
            },
        },
    },
    methods: {
        formatDate(date) {
            return date ? new Date(date).toISOString().substring(0, 10) : null
        }
    },
    computed: {
        localValue() {
            return this.value ? new Date(this.value.split('-')) : this.value
        }
    }
}
</script>

<style>

</style>