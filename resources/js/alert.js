import Swal from 'sweetalert2'

export function showSuccess(message, title = 'Sukses!') {
  Swal.fire({
    icon: 'success',
    title: title,
    text: message,
    background: '#ffffff',
    iconColor: '#16a34a',
    confirmButtonColor: '#16a34a',
  });
}

export function showError(message, title = 'Gagal!') {
  Swal.fire({
    icon: 'error',
    title: title,
    text: message,
    background: '#ffffff',
    iconColor: '#dc2626',
    confirmButtonColor: '#dc2626',
  });
}
