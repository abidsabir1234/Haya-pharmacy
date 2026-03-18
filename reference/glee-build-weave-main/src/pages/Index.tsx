import Header from "@/components/Header";
import HeroSection from "@/components/HeroSection";
import FeaturesSection from "@/components/FeaturesSection";
import TermsSection from "@/components/TermsSection";
import WhyHayaSection from "@/components/WhyHayaSection";
import CTASection from "@/components/CTASection";
import Footer from "@/components/Footer";
import patternBg from "@/assets/pattern-bg.png";

const Index = () => {
  return (
    <div className="min-h-screen bg-background relative">
      <div
        className="absolute inset-0 opacity-5 pointer-events-none z-0"
        style={{
          backgroundImage: `url(${patternBg})`,
          backgroundRepeat: 'repeat',
          backgroundSize: '400px',
        }}
      />
      <div className="relative z-10">
      <Header />
      <HeroSection />
      <FeaturesSection />
      <TermsSection />
      <WhyHayaSection />
      <CTASection />
      <Footer />
      </div>
    </div>
  );
};

export default Index;
