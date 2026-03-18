import { motion } from "framer-motion";
import hayaLogoWhite from "@/assets/haya-logo-white.png";

const Footer = () => {
  return (
    <motion.footer
      initial={{ opacity: 0 }}
      whileInView={{ opacity: 1 }}
      viewport={{ once: true }}
      transition={{ duration: 0.6 }}
      className="hero-section py-12 px-8 md:px-16"
    >
      <div className="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div className="flex items-center gap-3">
          <img src={hayaLogoWhite} alt="Haya Pharmacy" className="w-14 h-14 object-contain" />
          <div className="text-primary-foreground">
            <p className="font-bold text-lg">صيدلية حيــا</p>
            <p className="text-sm opacity-70">HAYA PHARMACY</p>
          </div>
        </div>
        <p className="text-primary-foreground opacity-60 text-sm">
          © 2026 صيدلية حيا. جميع الحقوق محفوظة
        </p>
      </div>
    </motion.footer>
  );
};

export default Footer;
