import { motion, AnimatePresence } from "framer-motion";
import { Instagram, Facebook, Menu, X } from "lucide-react";
import { useState, useEffect } from "react";
import hayaLogo from "@/assets/haya-logo.png";
import hayaLogoWhite from "@/assets/haya-logo-wide-white.png";

const Header = () => {
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => setScrolled(window.scrollY > 30);
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  // Prevent body scroll when menu is open
  useEffect(() => {
    document.body.style.overflow = menuOpen ? "hidden" : "";
    return () => { document.body.style.overflow = ""; };
  }, [menuOpen]);

  const socialLinks = (
    <>
      <a href="#" className="social-icon" aria-label="Instagram">
        <Instagram className="w-5 h-5" />
      </a>
      <a href="#" className="social-icon" aria-label="TikTok">
        <svg className="w-5 h-5 fill-current" viewBox="0 0 24 24">
          <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V8.71a8.27 8.27 0 004.76 1.5v-3.4a4.85 4.85 0 01-1-.12z" />
        </svg>
      </a>
      <a href="#" className="social-icon" aria-label="Snapchat">
        <svg className="w-5 h-5 fill-current" viewBox="0 0 24 24">
          <path d="M12.17 2C8.77 2 6.55 4.35 6.55 7.29v2.15c-.67-.08-1.34.14-1.7.54-.32.36-.38.84-.16 1.32.38.84 1.18 1.02 1.82 1.16.14.03.35.07.42.12-.1.28-.4.87-.76 1.33-.6.77-1.4 1.18-1.72 1.33-.56.26-.76.67-.65 1.08.1.38.45.65.87.73.33.06.67.09 1 .15.12.02.36.06.42.1.07.1.15.44.2.66.06.26.2.6.6.77.25.1.56.13.94.13.54 0 1.2-.1 2.04-.35a5.47 5.47 0 011.3-.15c.42 0 .83.05 1.3.15.84.25 1.5.35 2.04.35.38 0 .69-.04.94-.13.4-.17.54-.51.6-.77.05-.22.13-.56.2-.66.06-.04.3-.08.42-.1.33-.06.67-.09 1-.15.42-.08.77-.35.87-.73.11-.41-.09-.82-.65-1.08-.32-.15-1.12-.56-1.72-1.33-.36-.46-.66-1.05-.76-1.33.07-.05.28-.09.42-.12.64-.14 1.44-.32 1.82-1.16.22-.48.16-.96-.16-1.32-.36-.4-1.03-.62-1.7-.54V7.29C17.45 4.35 15.57 2 12.17 2z" />
        </svg>
      </a>
      <a href="#" className="social-icon" aria-label="Facebook">
        <Facebook className="w-5 h-5" />
      </a>
    </>
  );

  return (
    <>
      <motion.header
        initial={{ y: -40, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.6, ease: "easeOut" }}
        className={`sticky top-0 z-50 flex items-center justify-between px-5 md:px-16 transition-all duration-500 ${
          scrolled
            ? "py-3 backdrop-blur-xl bg-background/30 shadow-lg border-b border-border/50"
            : "py-5 bg-background/50 backdrop-blur-sm"
        }`}
      >
        {/* Logo */}
        <div className="relative h-[3.5rem] md:h-[5.75rem] w-auto">
          <img
            src={hayaLogo}
            alt="Haya Pharmacy Logo"
            className={`h-full object-contain transition-opacity duration-500 ${scrolled ? 'opacity-0' : 'opacity-100'}`}
          />
          <img
            src={hayaLogoWhite}
            alt="Haya Pharmacy Logo"
            className={`absolute inset-0 h-full object-contain transition-opacity duration-500 ${scrolled ? 'opacity-100' : 'opacity-0'}`}
          />
        </div>

        {/* Desktop social icons */}
        <div className="hidden md:flex items-center gap-3">
          {socialLinks}
        </div>

        {/* Mobile hamburger */}
        <button
          className="md:hidden p-2 rounded-md text-foreground hover:bg-muted transition-colors"
          onClick={() => setMenuOpen(true)}
          aria-label="فتح القائمة"
        >
          <Menu className="w-6 h-6" />
        </button>
      </motion.header>

      {/* Mobile menu overlay */}
      <AnimatePresence>
        {menuOpen && (
          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.3 }}
            className="fixed inset-0 z-[100] bg-primary/95 backdrop-blur-md flex flex-col items-center justify-center gap-10"
          >
            <button
              className="absolute top-5 left-5 p-2 rounded-md text-primary-foreground hover:bg-primary-foreground/10 transition-colors"
              onClick={() => setMenuOpen(false)}
              aria-label="إغلاق القائمة"
            >
              <X className="w-7 h-7" />
            </button>

            <img src={hayaLogoWhite} alt="Haya Pharmacy Logo" className="h-16 object-contain" />

            <motion.div
              initial={{ y: 20, opacity: 0 }}
              animate={{ y: 0, opacity: 1 }}
              transition={{ delay: 0.1, duration: 0.4 }}
              className="flex items-center gap-5 text-primary-foreground"
            >
              {socialLinks}
            </motion.div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
};

export default Header;
