<template>
  <div :class="[{ tiny: $sidebar.state }]">
     <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('properties')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('properties') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('properties') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Imóveis</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('locators')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('locators') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('locators') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Locadores</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('tenants')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('tenants') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('tenants') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Inquilinos</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('contracts')">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('contracts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('contracts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contratos</div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>
