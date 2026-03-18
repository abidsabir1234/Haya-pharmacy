import { motion } from "framer-motion";
import { ChevronLeft } from "lucide-react";

const features = [
  {
    title: "خصم إضافي 10% على المنتجات و الأجهزة",
    description: "",
  },
  {
    title: "فحص مجاني شهري",
    description: "",
  },
  {
    title: "توصيل مجاني",
    description: "",
  },
  {
    title: "عروض حصرية للأعضاء",
    description:
      'عروض أسبوعية أو شهرية متاحة حصراً لأعضاء حيا "الأوائل" فقط.',
  },
  {
    title: "قائمة أولوية للمنتجات غير المتوفرة",
    description:
      "إضافة العضو إلى قائمة إشعار فوري على الـ WhatsApp عند توفر المنتجات غير المتاحة (Out of Stock Priority List).",
  },
];

const cardVariants = {
  hidden: { y: 60, opacity: 0 },
  visible: (i: number) => ({
    y: 0,
    opacity: 1,
    transition: { duration: 0.5, delay: i * 0.15, ease: "easeOut" as const },
  }),
};

const FeaturesSection = () => {
  return (
    <section
      className="py-20 px-8 md:px-16"
      style={{
        background: 'radial-gradient(ellipse at center top, hsl(153, 55%, 18%) 0%, hsl(153, 50%, 10%) 40%, hsl(153, 45%, 5%) 70%, hsl(160, 40%, 3%) 100%)',
      }}
    >
      <motion.h2
        initial={{ y: 30, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6 }}
        className="text-5xl md:text-6xl lg:text-7xl font-extrabold text-center text-primary-foreground mb-16"
      >
        ميزات <span className="gold-text">"الأوائل"</span>
      </motion.h2>

      <div className="container mx-auto">
        {/* Top row - 3 small cards */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
          {features.slice(0, 3).map((feature, i) => (
            <motion.div
              key={i}
              custom={i}
              variants={cardVariants}
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              className="bg-background rounded-2xl p-8 flex items-center justify-between gap-4 cursor-pointer group border border-border/30"
            >
              <h3 className="text-lg md:text-xl font-bold text-primary flex-1 text-right">
                {feature.title}
              </h3>
              <div className="w-16 h-16 min-w-[4rem] rounded-full bg-white shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <div className="w-10 h-10 rounded-full bg-accent flex items-center justify-center">
                  <ChevronLeft className="w-5 h-5 text-white" />
                </div>
              </div>
            </motion.div>
          ))}
        </div>

        {/* Bottom row - 2 wider cards with descriptions */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
          {features.slice(3).map((feature, i) => (
            <motion.div
              key={i + 3}
              custom={i + 3}
              variants={cardVariants}
              initial="hidden"
              whileInView="visible"
              viewport={{ once: true }}
              className="bg-background rounded-2xl p-8 flex items-start justify-between gap-4 cursor-pointer group border border-border/30"
            >
              <div className="flex-1 text-right">
                <h3 className="text-lg md:text-xl font-bold text-primary mb-2">
                  {feature.title}
                </h3>
                {feature.description && (
                  <p className="text-foreground/70 text-sm md:text-base leading-relaxed">
                    {feature.description}
                  </p>
                )}
              </div>
              <div className="w-16 h-16 min-w-[4rem] rounded-full bg-white shadow-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 mt-1">
                <div className="w-10 h-10 rounded-full bg-accent flex items-center justify-center">
                  <ChevronLeft className="w-5 h-5 text-white" />
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default FeaturesSection;
