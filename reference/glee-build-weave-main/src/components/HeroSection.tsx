import { motion } from "framer-motion";
import loyaltyCards from "@/assets/loyalty-cards.png";
import patternBg from "@/assets/pattern-bg.png";

const HeroSection = () => {
  return (
    <section className="hero-section relative overflow-hidden min-h-[80vh] flex items-center">
      <div
        className="absolute inset-0 opacity-[0.03] pointer-events-none z-0"
        style={{
          backgroundImage: `url(${patternBg})`,
          backgroundRepeat: 'repeat',
          backgroundSize: '4000px',
        }}
      />
      {/* Decorative circles - matching Figma position */}
      <motion.div
        initial={{ scale: 0, opacity: 0 }}
        animate={{ scale: 1, opacity: 0.15 }}
        transition={{ duration: 1.2, delay: 0.6 }}
        className="absolute top-16 left-16 w-72 h-72 rounded-full border border-primary-foreground/20"
      />
      <motion.div
        initial={{ scale: 0, opacity: 0 }}
        animate={{ scale: 1, opacity: 0.1 }}
        transition={{ duration: 1.2, delay: 0.8 }}
        className="absolute top-24 left-24 w-56 h-56 rounded-full border border-primary-foreground/15"
      />

      <div className="container mx-auto px-8 md:px-16 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        {/* Card Image - shown first on mobile */}
        <motion.div
          initial={{ x: -80, opacity: 0, rotate: -5 }}
          animate={{ x: 0, opacity: 1, rotate: 0 }}
          transition={{ duration: 1, delay: 0.4, ease: "easeOut" }}
          className="order-1 lg:order-2 flex justify-center lg:justify-start"
        >
          <motion.img
            src={loyaltyCards}
            alt="بطاقة الأوائل الحصرية"
            className="w-full max-w-xs md:max-w-xl drop-shadow-2xl"
            animate={{ y: [0, -10, 0] }}
            transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
          />
        </motion.div>

        {/* Text Content */}
        <motion.div
          initial={{ x: 80, opacity: 0 }}
          animate={{ x: 0, opacity: 1 }}
          transition={{ duration: 0.8, delay: 0.3, ease: "easeOut" }}
          className="text-primary-foreground space-y-8 order-2 lg:order-1"
        >
          <motion.h2
            initial={{ y: 30, opacity: 0 }}
            animate={{ y: 0, opacity: 1 }}
            transition={{ duration: 0.7, delay: 0.5 }}
            className="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight"
          >
            <span className="gold-text">لأنك كُنت من "الأوائل"..</span>
            <br />
            شكراً لحضورك.
          </motion.h2>

          <motion.div
            initial={{ y: 20, opacity: 0 }}
            animate={{ y: 0, opacity: 1 }}
            transition={{ duration: 0.6, delay: 0.7 }}
            className="space-y-6 text-base md:text-lg leading-relaxed opacity-90"
          >
            <p>
              في اولى ايام الافتتاح، لم تكن مجرد زائر. بل كنت شريكاً لنا في خطوتنا الاولى.
              <br />
              وتقديراً منا لهذه الثقة وهذا الوقت الذي شاركتنا فيه فرحة البداية، يسعدنا ان
              <br />
              نهديك بطاقة <strong>"الاوائل" الحصرية.</strong>
            </p>
            <p>
              هذه البطاقة هي طريقتنا لنقول لك "شكراً من القلب"، ونمنحك اهتماماً خاصاً
              <br />
              كواحد من العائلة الذين شهدوا معنا لحظة الانطلاق.
            </p>
            <p className="text-xl font-medium">
              اهلا و مرحبا بك في اسرة <strong className="gold-text">صيدلية حيا</strong>
            </p>
          </motion.div>

          <motion.div
            initial={{ y: 20, opacity: 0 }}
            animate={{ y: 0, opacity: 1 }}
            transition={{ duration: 0.5, delay: 0.9 }}
          >
            <button className="cta-button">
              فعّل ميزات "الأوائل"
            </button>
          </motion.div>
        </motion.div>
      </div>
    </section>
  );
};

export default HeroSection;
