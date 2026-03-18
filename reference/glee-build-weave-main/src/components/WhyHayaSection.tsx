import { motion } from "framer-motion";
import { UserCheck, Gem, Handshake } from "lucide-react";

const reasons = [
  { icon: Handshake, text: "نخبة من الصيادلة الإستشاريين" },
  { icon: Gem, text: "أدوية مضمونة واصلية" },
  { icon: UserCheck, text: "صيدلية معتمدة" },
];

const WhyHayaSection = () => {
  return (
    <section className="bg-accent text-white py-16 px-8 md:px-16">
      <motion.h2
        initial={{ y: 30, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6 }}
        className="text-3xl md:text-4xl lg:text-5xl font-extrabold text-center mb-12"
      >
        ليش تختار صيدلية حَيّا؟
      </motion.h2>

      <div className="flex flex-wrap justify-center gap-8 md:gap-16">
        {reasons.map((reason, index) => (
          <motion.div
            key={index}
            initial={{ y: 20, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: index * 0.1 }}
            className="flex items-center gap-3"
          >
            <div className="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
              <reason.icon className="w-6 h-6 text-white" />
            </div>
            <span className="text-lg md:text-xl font-bold">{reason.text}</span>
          </motion.div>
        ))}
      </div>
    </section>
  );
};

export default WhyHayaSection;
