<template>
	<div :class="[{ tiny: $sidebar.state }]">
		<div v-for="(link, routeName) in links" :key="routeName" class="mb-4">
			<inertia-link class="flex items-center group py-3" :href="route(routeName)">
				<icon
					:name="link.icon"
					class="w-4 h-4 mr-2"
					:class="isUrl(routeName) ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'"
				/>
				<div
					:class="isUrl(routeName) ? 'text-white' : 'text-indigo-300 group-hover:text-white'"
				>
					{{ link.label }}
				</div>
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
  data() {
    return {
		links: {
			properties: {
				icon: 'users',
				label: 'Imóveis',
			},
			locators: {
				icon: 'office',
				label: 'Locadores',
			},
			tenants: {
				icon: 'users',
				label: 'Inquilinos',
			},
			contracts: {
				icon: 'printer',
				label: 'Contratos',
			},
			rental_payment: {
				icon: 'money',
				label: 'Aluguéis',
			},
		}
    }
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }
      return urls.filter(url => this.dashCaseToSnake(this.url).startsWith(url)).length
	},
	dashCaseToSnake(string) {
		return string.replace(/(.*)-(.*)/g, '$1_$2')
	}
  },
}
</script>
