import { motion } from "framer-motion";
import { CheckCircle2 } from "lucide-react";
import patternBg from "@/assets/pattern-bg.png";

const termsCategories = [
  {
    title: "الصلاحية والتفعيل (غير قابلة للتجديد)",
    items: [
      {
        text: 'تسري صلاحية بطاقة العضوية لمدة <strong>ستة (6) أشهر</strong> فقط، تبدأ من تاريخ تفعيل البطاقة.',
      },
      {
        text: '<strong>سياسة التجديد:</strong> هذه العضوية مخصصة لفترة محددة وهي <strong>غير قابلة للتجديد</strong> بنفس المزايا المجانية الحالية عند انتهائها. بعد انقضاء الستة أشهر، يمكن للعميل التقديم على باقات العضوية الجديدة المتوفرة في الصيدلية في حينها.',
      },
    ],
  },
  {
    title: "الفحوصات والاستشارات المجانية",
    items: [
      {
        text: 'يحق للعضو أو أحد أفراد عائلته من حاملي البطاقة الحصول على <strong>فحص مجاني واحد شهرياً.</strong>',
      },
      {
        text: 'يختار العضو خدمة واحدة فقط من بين: (<strong>Skin Analyzer / InBody / Hair Analyzer</strong>).',
      },
      {
        text: '<strong>شرط عدم التراكم:</strong> تسقط الاستفادة من الفحص الشهري بانتهاء الشهر التقويمي، ولا يحق للعضو المطالبة بالخدمات غير المستخدمة أو تدويرها للأشهر التالية.',
      },
      {
        text: 'تخضع الفحوصات لتوفر الأجهزة والمواعيد المتاحة لدى الصيدلية.',
      },
    ],
  },
  {
    title: "الخصومات على المنتجات والأجهزة",
    items: [
      {
        text: 'يحصل حامل البطاقة على <strong>خصم إضافي 10%</strong> على المنتجات والأجهزة المتوفرة في الصيدلية.',
      },
      {
        text: 'لا يشمل الخصم الأدوية أو المنتجات المخفضة مسبقاً أو العروض الخاصة.',
      },
    ],
  },
  {
    title: "السياسة السعرية والخصومات",
    items: [
      {
        text: '<strong>الأدوية:</strong> التزاماً بالقوانين والأنظمة الصحية في العراق، تخضع جميع الأدوية لسياسة <strong>التسعيرة الجبرية</strong>، ولا يشملها أي نوع من أنواع الخصومات والعروض الترويجية تحت أي ظرف.',
      },
      {
        text: 'تقتصر الخصومات على المستلزمات غير الدوائية (كالتجميل والمكملات الغذائية) التي تحددها إدارة الصيدلية حصراً.',
      },
    ],
  },
  {
    title: "خدمة التوصيل",
    items: [
      {
        text: 'توفر الصيدلية خدمة <strong>التوصيل المجاني</strong> للأعضاء داخل النطاق الجغرافي لمدينة <strong>بغداد</strong> حصراً.',
      },
      {
        text: 'يحق للصيدلية تحديد حد أدنى لقيمة الطلبات للاستفادة من ميزة <strong>التوصيل المجاني</strong>.',
      },
    ],
  },
  {
    title: "التواصل والخصوصية",
    items: [
      {
        text: 'يقر العضو بموافقته الصريحة على استلام الرسائل الترويجية، العروض، والتحديثات الطبية عبر تطبيق واتساب <strong>(WhatsApp)</strong> أو أي من وسائل الاتصال المسجلة.',
      },
      {
        text: 'تلتزم الصيدلية بالحفاظ على خصوصية بيانات العضو وعدم مشاركتها مع أي أطراف خارجية.',
      },
    ],
  },
  {
    title: "أحكام عامة",
    items: [
      {
        text: '<strong>تعديل الشروط:</strong> تحتفظ إدارة الصيدلية بالحق في تعديل أو تغيير أي من هذه الشروط والأحكام، أو تعديل باقة المزايا، مع إخطار الأعضاء بأي تغييرات جوهرية.',
      },
      {
        text: '<strong>إساءة الاستخدام:</strong> يحق للصيدلية إلغاء العضوية فوراً في حال ثبوت إساءة استخدام البطاقة أو تقديم معلومات غير صحيحة.',
      },
      {
        text: '<strong>الإخلاء من المسؤولية:</strong> الفحوصات المقدمة (InBody/Skin/Hair) هي فحوصات استرشادية، ولا تغني عن الاستشارة الطبية المتخصصة في الحالات المرضية.',
      },
    ],
  },
];

const TermsSection = () => {
  return (
    <section className="py-20 px-8 md:px-16 bg-background relative overflow-hidden">
      <div
        className="absolute inset-0 opacity-[0.04] pointer-events-none z-0"
        style={{
          backgroundImage: `url(${patternBg})`,
          backgroundRepeat: 'repeat',
          backgroundSize: '2800px',
        }}
      />
      <motion.h2
        initial={{ y: 30, opacity: 0 }}
        whileInView={{ y: 0, opacity: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6 }}
        className="text-3xl md:text-4xl lg:text-5xl font-extrabold text-primary mb-16 text-center relative z-10"
      >
        الشروط والأحكام
        <br />
        <span className="gold-text">الخاصة بعضوية الأوائل</span>
      </motion.h2>

      <div className="container mx-auto space-y-12 relative z-10">
        {termsCategories.map((category, catIndex) => (
          <motion.div
            key={catIndex}
            initial={{ y: 40, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.5, delay: catIndex * 0.15 }}
            className="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-6 items-start"
          >
            <h3 className="text-xl md:text-2xl font-bold text-primary">
              {category.title}
            </h3>
            <div className="space-y-6">
              {category.items.map((item, itemIndex) => (
                <motion.div
                  key={itemIndex}
                  initial={{ x: 30, opacity: 0 }}
                  whileInView={{ x: 0, opacity: 1 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.4, delay: itemIndex * 0.1 + 0.2 }}
                  className="flex gap-3 items-start"
                >
                  <CheckCircle2 className="w-6 h-6 min-w-[1.5rem] text-accent mt-1" />
                  <p
                    className="text-foreground leading-relaxed text-base md:text-lg"
                    dangerouslySetInnerHTML={{ __html: item.text }}
                  />
                </motion.div>
              ))}
            </div>
          </motion.div>
        ))}
      </div>
    </section>
  );
};

export default TermsSection;
