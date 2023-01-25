<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import CountriesDropDown from '@/Components/CountriesDropDown.vue';
    import PhoneInput from '@/Components/PhoneInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import countries from './../../Components/countries.json';
    const form = useForm({
        name: '',
        country: { "name": "Israel", "flag": "\ud83c\uddee\ud83c\uddf1", "idd": "+972" },
        phone: '',
        country_number: '+972',
        country_name: 'Israel',
        email: '',
        terms: false,
    });

    const changeCountry = (country) => {
        form.country = country;
        changePhoneNumber(country.idd)
    }
    
    const changePhoneNumber = (number) => {
        form.country_number = number
    }
    const submit = () => {
        form.country_name = form.country.name;
        form.country_number = form.country.idd;
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name"
                           type="text"
                           class="mt-1 block w-full"
                           v-model="form.name"
                           required
                           autofocus
                           autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="country" value="Country" />
                <div class="d-flex flex-column">
                <v-select 
                          v-model="form.country"
                          v-bind:items="countries"
                          item-title="name"
                          item-value="idd"
                          class="block w-full"
                          return-object
                          single-line
                          density="comfortable"
                          :menu-props="{
                          closeOnClick: true,
                          closeOnContentClick: true,
                          }"
                          ref="country">
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
                    <!--TODO: Error with css <CountriesDropDown 
                                   @on-change-country="onChangeCountry"
                                   @change-phone-number="changePhoneNumber"  />-->
                </div>
                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone number" />
                <PhoneInput id="phone"
                            class="mt-1 block w-full"
                            type="text"
                            v-model="form.phone"
                            :phone-prefix="form.country_number"
                            required
                            autocomplete="phone" />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput id="email"
                           type="email"
                           class="mt-1 block w-full"
                           v-model="form.email"
                           required
                           autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!--<div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password"
                           type="password"
                           class="mt-1 block w-full"
                           v-model="form.password"
                           required
                           autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput id="password_confirmation"
                           type="password"
                           class="mt-1 block w-full"
                           v-model="form.password_confirmation"
                           required
                           autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>-->

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                      class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
