<template>
    <a
    :class="[active ? 'bg-white text-red-700' : (highlight ? 'bg-yellow-300 text-gray-900 hover:bg-gray-200':'text-gray-100 hover:bg-gray-200 hover:text-red-600'), 'rounded-md px-3 py-2 font-medium']" :aria-current="active ? 'page' : undefined"
    >
        <slot />
</a>
</template>

<script>
export default{
    props:{
        active: Boolean,
        highlight: Boolean,
        name: String,
        key: String
    }
};
</script>