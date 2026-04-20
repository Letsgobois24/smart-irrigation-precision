export default function clock(time) {
    return {
        now: new Date(time),
        time: '',
        date: '',
        timer: null,
        init() {
            console.log(time);
            if (this.timer) return;

            this.update();
            this.timer = setInterval(() => {
                this.now.setSeconds(this.now.getSeconds() + 1);
                this.update();
            }, 1000);
        },
        update() {
            this.time = this.now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).replace(',', ':');
            this.date = this.now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
    }
}