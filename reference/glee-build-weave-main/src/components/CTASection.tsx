import { motion } from "framer-motion";
import { Phone, ClipboardList } from "lucide-react";
import patternBg from "@/assets/pattern-bg.png";

const CTASection = () => {
  return (
    <section className="bg-background py-20 px-8 md:px-16 relative overflow-hidden">
      <img
        src={patternBg}
        alt=""
        className="absolute -right-[34.25rem] top-1/2 -translate-y-1/2 w-auto h-auto max-h-[32rem] opacity-[0.08] pointer-events-none z-0 rotate-90"
      />
      <img
        src={patternBg}
        alt=""
        className="absolute -left-[34.25rem] top-1/2 -translate-y-1/2 w-auto h-auto max-h-[32rem] opacity-[0.08] pointer-events-none z-0 rotate-90 scale-x-[-1]"
      />
      <motion.h2
        initial={{ y: 30, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6 }}
        className="text-3xl md:text-4xl lg:text-5xl font-extrabold text-primary text-center mb-12 relative z-10"
      >
        جاهز تطلب؟
      </motion.h2>

      <div className="flex flex-col sm:flex-row items-center justify-center gap-6 relative z-10">
        <motion.a
          href="tel:+9647700000000"
          initial={{ y: 20, opacity: 0 }}
          whileInView={{ y: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.4, delay: 0.1 }}
          whileHover={{ scale: 1.06, boxShadow: "0 8px 30px rgba(0,0,0,0.2)" }}
          whileTap={{ scale: 0.97 }}
          className="flex items-center gap-3 px-10 py-4 rounded-full bg-accent text-white font-bold text-lg md:text-xl transition-opacity cursor-pointer"
        >
          اتصل بالخط الساخن
          <Phone className="w-6 h-6" />
        </motion.a>

        <motion.a
          href="https://wa.me/"
          target="_blank"
          rel="noopener noreferrer"
          initial={{ y: 20, opacity: 0 }}
          whileInView={{ y: 0, opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.4, delay: 0.2 }}
          whileHover={{ scale: 1.06, boxShadow: "0 8px 30px rgba(0,0,0,0.2)" }}
          whileTap={{ scale: 0.97 }}
          className="flex items-center gap-3 px-10 py-4 rounded-full bg-primary text-white font-bold text-lg md:text-xl transition-opacity cursor-pointer"
        >
          اطلب الآن عبر واتساب
          <ClipboardList className="w-6 h-6" />
        </motion.a>
      </div>
    </section>
  );
};

export default CTASection;
