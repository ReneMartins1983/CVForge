import './bootstrap';
import Alpine from 'alpinejs';

/* -------------------------------------------------------------------------
 * Dark mode (estratégia "class" do Tailwind, persistido em localStorage)
 * O estado inicial é aplicado por um script inline no <head> para evitar
 * o flash de tema. Aqui ficam só os utilitários do toggle.
 * ---------------------------------------------------------------------- */
window.toggleDark = () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
};

window.isDark = () => document.documentElement.classList.contains('dark');

/* -------------------------------------------------------------------------
 * Builder do currículo — estado reativo do formulário + preview ao vivo
 * ---------------------------------------------------------------------- */
function emptyResume() {
    return {
        personal: {
            name: '',
            title: '',
            email: '',
            phone: '',
            location: '',
            website: '',
            linkedin: '',
            github: '',
            summary: '',
        },
        experiences: [],
        education: [],
        skills: [],
        projects: [],
        languages: [],
    };
}

Alpine.data('builder', (initial = {}) => ({
    title: initial.title || 'Meu currículo',
    template: initial.template || 'modern',
    resume: { ...emptyResume(), ...(initial.data || {}) },
    skillInput: '',
    saving: false,

    // foto de perfil (templates com foto)
    withPhoto: initial.withPhoto || [],
    photoUrl: initial.photoUrl || null, // foto já salva (edição)
    photoPreview: null,                 // preview de um novo upload
    removePhoto: false,

    get usesPhoto() {
        return this.withPhoto.includes(this.template);
    },
    get shownPhoto() {
        if (this.photoPreview) return this.photoPreview;
        return this.removePhoto ? null : this.photoUrl;
    },
    onPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            this.photoPreview = URL.createObjectURL(file);
            this.removePhoto = false;
        }
    },
    clearPhoto() {
        this.photoPreview = null;
        this.photoUrl = null;
        this.removePhoto = true;
        if (this.$refs.photoInput) this.$refs.photoInput.value = '';
    },

    init() {
        // garante que todas as coleções existam mesmo em currículos antigos
        const base = emptyResume();
        for (const key of Object.keys(base)) {
            if (this.resume[key] === undefined) this.resume[key] = base[key];
        }
        this.resume.personal = { ...base.personal, ...this.resume.personal };
    },

    // Experiências
    addExperience() {
        this.resume.experiences.push({ role: '', company: '', start: '', end: '', description: '' });
    },
    removeExperience(i) {
        this.resume.experiences.splice(i, 1);
    },

    // Formação
    addEducation() {
        this.resume.education.push({ degree: '', institution: '', start: '', end: '', description: '' });
    },
    removeEducation(i) {
        this.resume.education.splice(i, 1);
    },

    // Projetos
    addProject() {
        this.resume.projects.push({ name: '', link: '', description: '' });
    },
    removeProject(i) {
        this.resume.projects.splice(i, 1);
    },

    // Idiomas
    addLanguage() {
        this.resume.languages.push({ name: '', level: '' });
    },
    removeLanguage(i) {
        this.resume.languages.splice(i, 1);
    },

    // Habilidades (chips)
    addSkill() {
        const value = this.skillInput.trim();
        if (value && !this.resume.skills.includes(value)) {
            this.resume.skills.push(value);
        }
        this.skillInput = '';
    },
    removeSkill(i) {
        this.resume.skills.splice(i, 1);
    },

    get hasContacts() {
        const p = this.resume.personal;
        return p.email || p.phone || p.location || p.website || p.linkedin || p.github;
    },

    // serializa o estado para o input escondido enviado ao servidor
    get payload() {
        return JSON.stringify(this.resume);
    },
}));

window.Alpine = Alpine;
Alpine.start();
