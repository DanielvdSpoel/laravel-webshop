<template>
    <BaseField :name="name" :label="label" :description="description" :required="required" :form="form">
        <div  class="mt-2 grid gap-1" :style="'grid-template-columns: repeat(' + fields + ', minmax(0, 1fr));'">
            <template v-for="(v, index) in values" :key="index">
                <input
                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block border-gray-300 rounded-sm w-12 h-12 text-lg text-center"
                    v-bind:class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500': error}"
                    type="text"
                    pattern="[0-9]"
                    :autoFocus="autoFocus && index === autoFocusIndex"
                    :data-id="index"
                    :value="v"
                    :ref="
            (el) => {
              if (el) inputs[index + 1] = el;
            }
          "
                    v-on:input="onValueChange"
                    v-on:focus="onFocus"
                    v-on:keydown="onKeyDown"
                    :required="props.required"
                    :disabled="props.disabled"
                    maxlength="1"
                />
            </template>

        </div>
    </BaseField>
</template>

<script setup>
import { defineProps, defineEmits, ref, toRef, onBeforeUpdate, computed } from "vue";
import BaseField from "./BaseField";
import { usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
    className: String,
    fields: {
        type: Number,
        default: 3,
    },
    modelValue: String|Number,
    form: Object,
    name: String,
    label: String,
    placeholder: String,
    description: String,
    required: Boolean,
    disabled: Boolean,
});
const emit = defineEmits(["update:modelValue"]);
const KEY_CODE = {
    backspace: 8,
    left: 37,
    up: 38,
    right: 39,
    down: 40,
};
const values = ref([]);
const iRefs = ref([]);
const inputs = ref([]);
const fields = toRef(props, "fields");
const autoFocusIndex = ref(0);
const autoFocus = true;

const error = computed(() => usePage().props.value.errors[props.name])



const initVals = () => {
    let vals;
    if (values.value && values.value.length) {
        vals = [];
        for (let i = 0; i < fields.value; i++) {
            vals.push(values.value[i] || "");
        }
        autoFocusIndex.value =
            values.value.length >= fields.value ? 0 : values.value.length;
    } else {
        vals = Array(fields.value).fill("");
    }
    iRefs.value = [];
    for (let i = 0; i < fields.value; i++) {
        iRefs.value.push(i + 1);
    }
    values.value = vals;
};
const onFocus = (e) => {
    e.target.select(e);
};
const onValueChange = (e) => {
    const index = parseInt(e.target.dataset.id);
    e.target.value = e.target.value.replace(/[^\d]/gi, "");
    // this.handleKeys[index] = false;
    if (e.target.value === "" || !e.target.validity.valid) {
        return;
    }
    let next;
    const value = e.target.value;
    values.value = Object.assign([], values.value);
    if (value.length > 1) {
        let nextIndex = value.length + index - 1;
        if (nextIndex >= fields.value) {
            nextIndex = fields.value - 1;
        }
        next = iRefs.value[nextIndex];
        const split = value.split("");
        split.forEach((item, i) => {
            const cursor = index + i;
            if (cursor < fields.value) {
                values.value[cursor] = item;
            }
        });
    } else {
        next = iRefs.value[index + 1];
        values.value[index] = value;
    }
    if (next) {
        const element = inputs.value[next];
        element.focus();
        element.select();
    }
    triggerChange(values.value);
};
const onKeyDown = (e) => {
    const index = parseInt(e.target.dataset.id);
    const prevIndex = index - 1;
    const nextIndex = index + 1;
    const prev = iRefs.value[prevIndex];
    const next = iRefs.value[nextIndex];
    switch (e.keyCode) {
        case KEY_CODE.backspace: {
            e.preventDefault();
            const vals = [...values.value];
            if (values.value[index]) {
                vals[index] = "";
                values.value = vals;
                triggerChange(vals);
            } else if (prev) {
                vals[prevIndex] = "";
                inputs.value[prev].focus();
                values.value = vals;
                triggerChange(vals);
            }
            break;
        }
        case KEY_CODE.left:
            e.preventDefault();
            if (prev) {
                inputs.value[prev].focus();
            }
            break;
        case KEY_CODE.right:
            e.preventDefault();
            if (next) {
                inputs.value[next].focus();
            }
            break;
        case KEY_CODE.up:
        case KEY_CODE.down:
            e.preventDefault();
            break;
        default:
            // this.handleKeys[index] = true;
            break;
    }
};
const triggerChange = (values = values.value) => {
    const val = values.join("");
    emit("update:modelValue", val);
};
initVals();
onBeforeUpdate(() => {
    inputs.value = [];
});
</script>

<style scoped>
</style>
