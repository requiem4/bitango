<script setup>
import { onMounted, ref } from 'vue';
import countries from './countries.json';

defineProps(['modelValue']);

const emit = defineEmits(['update:modelValue','onChangeCountry','changePhoneNumber']);
    
    let searchTerm = '';
    let countriesCopy = [];
    let searchCountries = []
    onMounted(() => {     
        countriesCopy = [...countries];
        searchCountries = [...countries];
        console.log(searchCountries)
    });
     
    const changeCountry = (country) => {
        emit('onChangeCountry', country)
        emit('changePhoneNumber', country.idd)
    }
    
    const searchCountry = (e) => {
      if (!searchTerm) {
        searchCountries = countriesCopy;
        }
        
        searchCountries = countriesCopy.filter((country) => {
            return country.name.toLowerCase().indexOf(searchTerm.toLowerCase()) > -1;
        });
    }
    const getCountries = () => {
        return searchCountries;
    }
    const initCountry = () => {
        emit('input', this.modelValue)
    }
</script>

<template>
    <div>
                <v-select outlined
                          :value="modelValue"
                           @input="initCountry()"
                          v-bind:items="searchCountries"
                          item-title="name"
                          item-value="idd"
                          class="mt-1 block w-full"
                          return-object
                          single-line
                          ref="country">
                    <template v-slot:prepend-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-text-field v-model="searchTerm" placeholder="Search" @input="searchCountry"></v-text-field>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2"></v-divider>
                    </template>
                    <template v-slot:selection="{ item, index }">
                        <v-list-item>
                            <v-list-item-action>
                                {{item.props.value.flag}}
                                {{item.props.title}}
                            </v-list-item-action>
                        </v-list-item>
                    </template>
                    <template v-slot:item="item">
                        <v-list-item :key="item.props.value.idd"
                                     @click="changeCountry(item.props.value)">
                            <v-list-item-action>
                                {{item.props.value.flag}}
                                {{item.props.title}}
                            </v-list-item-action>
                        </v-list-item>
                    </template>
                </v-select>
        </div>
</template>
