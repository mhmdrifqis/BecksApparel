function loginApp() {
    return {
        showLogin: false,
        activeRole: 'customer',
        email: '',
        password: '',
        roles: {
            customer: { label: 'Pelanggan', shortName: 'Pelanggan', icon: 'shopping-bag', redirect: '/customer/dashboard' },
            production: { label: 'Tim Produksi', shortName: 'Produksi', icon: 'scissors', redirect: '/production/dashboard' },
            admin: { label: 'Administrator', shortName: 'Admin', icon: 'shield-check', redirect: '/admin/dashboard' }
        },
        setRole(roleKey) {
            this.activeRole = roleKey;
            this.email = '';
            this.password = '';
            setTimeout(() => { if (window.lucide) window.lucide.createIcons(); }, 50);
        },
        openLogin() { this.showLogin = true; setTimeout(() => { if (window.lucide) window.lucide.createIcons(); }, 60); },
        closeLogin() { this.showLogin = false; },
        handleLogin() {
            if (!this.email || !this.password) { alert('Silakan isi email dan password!'); return; }
            const target = this.roles[this.activeRole].redirect;
            const btn = document.querySelector('button[type="submit"]');
            if (btn) { const original = btn.innerHTML; btn.innerHTML = '<span class="animate-spin mr-2">⏳</span> MEMPROSES...'; btn.classList.add('opacity-75','cursor-not-allowed'); }
            setTimeout(() => { window.location.href = target; }, 800);
        }
    }
}

// ensure icons render when page loads and when modal appears
document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) window.lucide.createIcons();
});
