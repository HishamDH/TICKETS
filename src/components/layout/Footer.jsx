
import React from 'react';

const Footer = ({ handleNavigation }) => {
  const handleLinkClick = (e, view) => {
    e.preventDefault();
    if (view) {
      handleNavigation(view);
    }
  };

  return (
    <footer className="bg-slate-900 text-white py-12">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
          <div>
            <div className="flex items-center mb-4 cursor-pointer" onClick={() => handleNavigation('home')}>
              <img 
                alt="شعار شباك التذاكر"
                className="w-10 h-10 ml-3"
               src="https://images.unsplash.com/photo-1674634044801-de885454a7c2" />
              <span className="text-xl font-bold text-white">شباك التذاكر</span>
            </div>
            <p className="text-gray-400 text-sm leading-relaxed">
              البوابة الذكية لحجوزات الفعاليات والمطاعم والمعارض، بوابتك نحو تجربة فريدة.
            </p>
          </div>
          <div>
            <span className="text-lg font-semibold mb-4 block text-gray-200">خدماتنا</span>
            <ul className="space-y-3 text-sm text-gray-400">
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'features')} className="hover:text-primary transition-colors">إدارة الفعاليات</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'features')} className="hover:text-primary transition-colors">حجوزات المطاعم</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'features')} className="hover:text-primary transition-colors">تنظيم المعارض</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'checkin')} className="hover:text-primary transition-colors">نظام التحقق</a></li>
            </ul>
          </div>
          <div>
            <span className="text-lg font-semibold mb-4 block text-gray-200">روابط سريعة</span>
            <ul className="space-y-3 text-sm text-gray-400">
               <li><a href="#" onClick={(e) => handleLinkClick(e, 'home')} className="hover:text-primary transition-colors">الرئيسية</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'features')} className="hover:text-primary transition-colors">المميزات</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'roles')} className="hover:text-primary transition-colors">الأدوار والرحلات</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'pricing')} className="hover:text-primary transition-colors">الأسعار</a></li>
              <li><a href="#" onClick={(e) => handleLinkClick(e, 'merchant-register')} className="hover:text-primary transition-colors">انضم كتاجر</a></li>
            </ul>
          </div>
          <div>
            <span className="text-lg font-semibold mb-4 block text-gray-200">تواصل معنا</span>
            <div className="space-y-3 text-sm text-gray-400">
              <p>البريد: <a href="mailto:info@shobaktickets.com" className="hover:text-primary transition-colors">info@shobaktickets.com</a></p>
              <p>الهاتف: <a href="tel:+966111234567" className="hover:text-primary transition-colors">+966 11 XXX XXXX</a></p>
              <p>العنوان: الرياض، المملكة العربية السعودية</p>
            </div>
          </div>
        </div>
        <div className="border-t border-gray-800 mt-8 pt-8 text-center">
          <p className="text-gray-500 text-sm">
            © {new Date().getFullYear()} شباك التذاكر. جميع الحقوق محفوظة.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
