import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import Snackbar from '@/Components/Snackbar';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from "@inertiajs/react";
import axios from 'axios';
import { FormEventHandler, useState } from "react";



export default function TwoFactorAuthenticate () {
  const { data, setData, post, get, processing, errors, reset } = useForm({
    two_factor_auth_code: '',
  });
  
  const submit: FormEventHandler = (e) => {
    e.preventDefault();
    console.log(data);
    post(route('two-factor.store'));
  }

  const [snackbarVisible, setSnackbarVisible] = useState(false);

  const getTwoFactorCode = () => {
    axios.get(route('two-factor-create', { id: 1}))
      .then(response => {
        if (response.status === 200) {
          setSnackbarVisible(true);
        };
      });
  }

  return (
    <GuestLayout>
      <Head title='2段階認証' />

      <form onSubmit={submit}>
        <div>
          <InputLabel htmlFor='two_factor_auth_code' value='2段階認証コード' />

          <TextInput
            id='two_factor_auth_code'
            name='two_factor_auth_code'
            value={data.two_factor_auth_code}
            className='mt-1 block w-full'
            autoComplete='one-time-code'
            isFocused={true}
            onChange={(e) => setData('two_factor_auth_code', e.target.value)}
          />
          <InputError message={errors.two_factor_auth_code} className='mt-2' />
        </div>

        <div className='flex items-center justify-between mt-4'>
          <button
            type='button'
            className='underline text-sm text-gray-600 hover:text-gray-900'
            onClick={getTwoFactorCode}
          >
            認証コードを再送信
          </button>
          <PrimaryButton type="submit" className={processing ? 'opacity-25' : ''} disabled={processing}>
            2段階認証
          </PrimaryButton>
        </div>
      </form>
      {snackbarVisible && (
        <Snackbar
          message="認証コードを再送信しました"
          type="success"
          duration={2000}
          onClose={() => setSnackbarVisible(false)}
        />
      )}
    </GuestLayout>
  )
}