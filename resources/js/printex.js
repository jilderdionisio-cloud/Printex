

const PrintexStorage = {
    keys: {
        users: 'printex_users',
        products: 'printex_products',
        courses: 'printex_courses',
        cart: 'printex_cart',
        orders: 'printex_orders',
        enrollments: 'printex_course_enrollments',
        activeUser: 'printex_active_user',
    },

    get(key, fallback = []) {
        try {
            const raw = localStorage.getItem(key);
            return raw ? JSON.parse(raw) : fallback;
        } catch {
            return fallback;
        }
    },

    set(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    },
};

const PrintexSeed = {
    users: [
        {
            id: crypto.randomUUID(),
            name: 'Admin Printex',
            email: 'admin@printex.com',
            password: 'admin123',
            phone: '999888777',
            role: 'admin',
            createdAt: new Date().toISOString(),
        },
    ],
    products: [
        { name: 'Tinta Sublimática EPSON 1L', price: 89.9, category: 'Tintas', stock: 50, image: '', description: 'Calidad premium para sublimación.' },
        { name: 'Plancha Transfer 38x38cm', price: 1850, category: 'Maquinaria', stock: 15, image: '', description: 'Plancha profesional de alta presión.' },
        { name: 'Papel Transfer A4 (100 hojas)', price: 45, category: 'Papeles', stock: 200, image: '', description: 'Papel transfer compatible con tintas eco.' },
        { name: 'Vinilo Textil Blanco Rollo 50cm', price: 65, category: 'Vinilos', stock: 80, image: '', description: 'Vinilo de corte con alta adherencia.' },
        { name: 'Prensa Térmica 5 en 1', price: 2350, category: 'Maquinaria', stock: 10, image: '', description: 'Incluye accesorios para tazas, gorras y platos.' },
        { name: 'Marco Serigráfico 40x50cm', price: 120, category: 'Serigrafía', stock: 35, image: '', description: 'Aluminio reforzado, malla 120 hilos.' },
        { name: 'Tinta Plastisol Negro 1kg', price: 95, category: 'Tintas', stock: 60, image: '', description: 'Secado rápido, acabado brillante.' },
        { name: 'Emulsión Fotográfica 1L', price: 85, category: 'Serigrafía', stock: 40, image: '', description: 'Fácil de aplicar y revelar.' },
        { name: 'Rasqueta Serigrafía 30cm', price: 25, category: 'Herramientas', stock: 100, image: '', description: 'Mango ergonómico y goma reemplazable.' },
        { name: 'Impresora Sublimática A4', price: 1650, category: 'Maquinaria', stock: 8, image: '', description: 'Incluye sistema continuo y tintas iniciales.' },
        { name: 'Papel Sublimático A3 (100 hojas)', price: 68, category: 'Papeles', stock: 150, image: '', description: 'Secado rápido y alta transferencia.' },
        { name: 'Kit Completo Iniciación Sublimación', price: 3200, category: 'Kits', stock: 5, image: '', description: 'Todo lo necesario para iniciar negocio.' },
    ],
    courses: [
        { name: 'Curso Básico de Sublimación', price: 350, duration: '4 semanas', modality: 'Presencial', slots: 20, instructor: 'Ana Gómez', description: 'Aprende desde cero la técnica de sublimación.', image: '' },
        { name: 'Curso Avanzado de Serigrafía', price: 450, duration: '6 semanas', modality: 'Presencial', slots: 15, instructor: 'Luis Ramos', description: 'Profundiza en procesos avanzados de serigrafía.', image: '' },
        { name: 'Curso Transfer y Estampado Textil', price: 400, duration: '5 semanas', modality: 'Híbrido', slots: 18, instructor: 'María Torres', description: 'Combina teoría online y práctica presencial.', image: '' },
    ],
};

const PrintexApp = {
    init() {
        this.bootstrapData();
        this.auth.syncUI();
        this.cart.updateBadge();
        this.forms.enableValidation();
        this.auth.bindToggle();
    },

    bootstrapData() {
        // Inicializa datos si no existen
        if (!localStorage.getItem(PrintexStorage.keys.users)) {
            const users = PrintexSeed.users.map(user => ({ ...user, id: crypto.randomUUID() }));
            PrintexStorage.set(PrintexStorage.keys.users, users);
            PrintexStorage.set(PrintexStorage.keys.activeUser, users[0]);
        }

        if (!localStorage.getItem(PrintexStorage.keys.products)) {
            const products = PrintexSeed.products.map(product => ({
                ...product,
                id: crypto.randomUUID(),
            }));
            PrintexStorage.set(PrintexStorage.keys.products, products);
        }

        if (!localStorage.getItem(PrintexStorage.keys.courses)) {
            const courses = PrintexSeed.courses.map(course => ({
                ...course,
                id: crypto.randomUUID(),
            }));
            PrintexStorage.set(PrintexStorage.keys.courses, courses);
        }

        if (!localStorage.getItem(PrintexStorage.keys.cart)) {
            PrintexStorage.set(PrintexStorage.keys.cart, []);
        }
        if (!localStorage.getItem(PrintexStorage.keys.orders)) {
            PrintexStorage.set(PrintexStorage.keys.orders, []);
        }
        if (!localStorage.getItem(PrintexStorage.keys.enrollments)) {
            PrintexStorage.set(PrintexStorage.keys.enrollments, []);
        }
    },

    auth: {
        getActive() {
            return PrintexStorage.get(PrintexStorage.keys.activeUser, null);
        },

        setActive(user) {
            PrintexStorage.set(PrintexStorage.keys.activeUser, user);
        },

        toggleRole() {
            const current = this.getActive();
            if (!current) return;
            const nextRole = current.role === 'admin' ? 'cliente' : 'admin';
            const updated = { ...current, role: nextRole };
            this.setActive(updated);
            this.syncUI();
        },

        syncUI() {
            const user = this.getActive() ?? { name: 'Invitado', role: 'cliente' };
            document.querySelectorAll('[data-profile-name]').forEach(el => {
                el.textContent = user.name;
            });
            document.querySelectorAll('[data-profile-role]').forEach(el => {
                el.textContent = user.role.toUpperCase();
                el.classList.toggle('bg-danger', user.role === 'admin');
            });
            document.querySelectorAll('[data-role-guard="admin"]').forEach(el => {
                el.classList.toggle('d-none', user.role !== 'admin');
            });
        },

        bindToggle() {
            document.querySelectorAll('[data-profile-toggle]').forEach(button => {
                button.addEventListener('click', () => this.toggleRole());
            });
        },
    },

    cart: {
        get() {
            return PrintexStorage.get(PrintexStorage.keys.cart, []);
        },

        save(cart) {
            PrintexStorage.set(PrintexStorage.keys.cart, cart);
            PrintexApp.cart.updateBadge();
        },

        add(productId, quantity = 1) {
            const cart = this.get();
            const existing = cart.find(item => item.productId === productId);
            if (existing) {
                existing.quantity = Math.min(existing.quantity + quantity, 99);
            } else {
                cart.push({ productId, quantity });
            }
            this.save(cart);
        },

        update(productId, quantity) {
            const cart = this.get().map(item =>
                item.productId === productId ? { ...item, quantity: Math.max(1, quantity) } : item
            );
            this.save(cart);
        },

        remove(productId) {
            const cart = this.get().filter(item => item.productId !== productId);
            this.save(cart);
        },

        clear() {
            this.save([]);
        },

        updateBadge() {
            const count = this.get().reduce((total, item) => total + item.quantity, 0);
            document.querySelectorAll('[data-cart-count]').forEach(badge => {
                badge.textContent = count;
            });
        },
    },

    orders: {
        list() {
            return PrintexStorage.get(PrintexStorage.keys.orders, []);
        },

        create({ items, total, paymentMethod, userId }) {
            const orders = this.list();
            const newOrder = {
                id: crypto.randomUUID(),
                userId,
                items,
                total,
                paymentMethod,
                status: 'Pendiente',
                createdAt: new Date().toISOString(),
            };
            orders.push(newOrder);
            PrintexStorage.set(PrintexStorage.keys.orders, orders);
            PrintexApp.cart.clear();
            return newOrder;
        },

        byUser(userId) {
            return this.list().filter(order => order.userId === userId);
        },
    },

    courses: {
        list() {
            return PrintexStorage.get(PrintexStorage.keys.courses, []);
        },
    },

    enrollments: {
        list() {
            return PrintexStorage.get(PrintexStorage.keys.enrollments, []);
        },

        create({ courseId, userId, student }) {
            const enrollments = this.list();
            const newEnrollment = {
                id: crypto.randomUUID(),
                courseId,
                userId,
                studentName: student.name,
                studentEmail: student.email,
                studentPhone: student.phone,
                studentAddress: student.address,
                status: 'Activo',
                enrolledAt: new Date().toISOString(),
            };
            enrollments.push(newEnrollment);
            PrintexStorage.set(PrintexStorage.keys.enrollments, enrollments);
            return newEnrollment;
        },

        byUser(userId) {
            return this.list().filter(enrollment => enrollment.userId === userId);
        },
    },

    forms: {
        enableValidation() {
            const forms = document.querySelectorAll('.needs-validation, [data-validate="bootstrap"]');
            forms.forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });

                form.querySelectorAll('input, select, textarea').forEach(field => {
                    field.addEventListener('input', () => {
                        if (field.checkValidity()) {
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        } else {
                            field.classList.remove('is-valid');
                            field.classList.add('is-invalid');
                        }
                    });
                });
            });
        },
    },
};

document.addEventListener('DOMContentLoaded', () => {
    PrintexApp.init();

    
    document.querySelectorAll('[data-add-to-cart]').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product-id');
            const quantity = Number(button.getAttribute('data-quantity') ?? 1);
            if (productId) {
                PrintexApp.cart.add(productId, quantity);
            }
        });
    });
});

window.PrintexApp = PrintexApp;
