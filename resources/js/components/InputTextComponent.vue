<template>
    <input
        type="text"
        v-bind="$attrs"
        v-on="$listeners"
    >
</template>

<style lang="scss" scope>
    input {
        font-size: 1.2em;
        padding: 10px;
        border: 1px solid #ccc;
        width: 100%;
        margin-bottom: 15px;
    }
</style>
