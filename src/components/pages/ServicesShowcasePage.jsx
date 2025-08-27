import React, { useState, useMemo } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Badge } from '@/components/ui/badge';
import { Star, MapPin, Search, SlidersHorizontal, Building2, UtensilsCrossed, Camera, Palette as PaletteIcon, Music, Truck, Shield as ShieldIcon, Flower2, Sparkles, ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight, Heart } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const serviceCategories = {
  all: { name: 'كل الخدمات', icon: Sparkles },
  venues: { name: 'قاعات وقصور', icon: Building2 },
  catering: { name: 'إعاشة وبوفيه', icon: UtensilsCrossed },
  photography: { name: 'تصوير وفيديو', icon: Camera },
  beauty: { name: 'تجميل ومكياج', icon: PaletteIcon },
  entertainment: { name: 'عروض ترفيهية', icon: Music },
  transportation: { name: 'نقل ومواصلات', icon: Truck },
  security: { name: 'حراسة وأمن', icon: ShieldIcon },
  flowers_invitations: { name: 'ورود ودعوات', icon: Flower2 },
};

const sampleServices = [
  { id: 1, merchantId: 'merch1', name: 'قصر الأفراح الملكي', category: 'venues', location: 'الرياض', priceRange: '$$$', rating: 4.8, image: 'https://images.unsplash.com/photo-1587080414904-76938b079913?q=80&w=400', description: 'قاعة فاخرة تتسع لـ 500 ضيف مع خدمات متكاملة لزفاف الأحلام.' },
  { id: 2, merchantId: 'merch2', name: 'استوديو العدسة الذهبية', category: 'photography', location: 'جدة', priceRange: '$$', rating: 4.5, image: 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=400', description: 'تصوير احترافي لجميع مناسباتك مع فريق مبدع ومعدات حديثة.' },
  { id: 3, merchantId: 'merch3', name: 'مطابخ النخبة للضيافة', category: 'catering', location: 'الدمام', priceRange: '$$', rating: 4.9, image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=400', description: 'أشهى المأكولات وبوفيهات فاخرة تناسب جميع الأذواق والمناسبات.' },
  { id: 4, merchantId: 'merch_beauty_1', name: 'صالون الجمال الأنيق', category: 'beauty', location: 'الرياض', priceRange: '$$', rating: 4.6, image: 'https://images.unsplash.com/photo-1596704017254-9b12100ab13c?q=80&w=400', description: 'خدمات تجميل ومكياج احترافية لإطلالة ساحرة في يومك الخاص.' },
  { id: 5, merchantId: 'merch_music_1', name: 'فرقة الألحان الذهبية', category: 'entertainment', location: 'الخبر', priceRange: '$$$', rating: 4.7, image: 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=400', description: 'أجمل الألحان والعروض الموسيقية لإضفاء جو من البهجة على مناسبتك.' },
  { id: 6, merchantId: 'merch_venue_2', name: 'قاعة اللؤلؤة للمناسبات', category: 'venues', location: 'جدة', priceRange: '$$$$', rating: 4.9, image: 'https://images.unsplash.com/photo-1542665952-14513db15293?q=80&w=400', description: 'قاعة بتصميم عصري وخدمات راقية لإقامة حفلات زفاف ومؤتمرات لا تُنسى.' },
  { id: 7, merchantId: 'merch_photo_2', name: 'مصور الأعراس المبدع', category: 'photography', location: 'الرياض', priceRange: '$$$', rating: 4.7, image: 'https://images.unsplash.com/photo-1519225349531-b5a939330127?q=80&w=400', description: 'توثيق لحظاتكم السعيدة بأسلوب فني وإبداعي فريد من نوعه.' },
  { id: 8, merchantId: 'merch_cater_2', name: 'بوفيهات السعادة', category: 'catering', location: 'الرياض', priceRange: '$$', rating: 4.4, image: 'https://images.unsplash.com/photo-1600370400044-730f85949198?q=80&w=400', description: 'تشكيلة واسعة من الأطباق الشهية والمقبلات المتنوعة لجميع المناسبات.' },
];

const ITEMS_PER_PAGE = 6;

const ServiceCard = ({ service, handleNavigation }) => {
  const { toast } = useToast();
  const handleBookNow = () => {
    handleNavigation('public-booking', { merchantId: service.merchantId, merchantName: service.name });
  };

  const handleAddToFavorites = () => {
     toast({
      title: `❤️ ${service.name} أضيفت للمفضلة!`,
      description: "يمكنك العثور عليها لاحقًا في قائمة المفضلة الخاصة بك.",
      className: "bg-pink-500 text-white",
    });
     toast({
        title: "🚧 ميزة قيد التطوير",
        description: `ميزة "المفضلة" ليست مفعلة بعد، ولكن يمكنك طلبها في رسالتك القادمة! 🚀`,
        variant: "default",
    });
  }

  return (
    <Card className="overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
      <div className="relative">
        <img  
            src={service.image} 
            alt={`صورة لـ ${service.name}`} 
            className="w-full h-56 object-cover" 
        />
        <Badge variant="destructive" className="absolute top-3 right-3 text-sm px-3 py-1.5">{service.priceRange}</Badge>
        <Button size="icon" variant="ghost" className="absolute top-3 left-3 bg-white/70 hover:bg-white text-pink-500 rounded-full backdrop-blur-sm" onClick={handleAddToFavorites}>
            <Heart className="w-5 h-5" />
        </Button>
      </div>
      <CardHeader className="pb-3">
        <CardTitle className="text-xl font-bold text-slate-800 truncate">{service.name}</CardTitle>
        <div className="flex items-center text-sm text-slate-500 gap-2">
          <MapPin className="w-4 h-4 text-primary" />
          <span>{service.location}</span>
          <span className="mx-1">•</span>
          <Star className="w-4 h-4 text-amber-400 fill-amber-400" />
          <span>{service.rating}</span>
        </div>
      </CardHeader>
      <CardContent className="flex-grow">
        <p className="text-slate-600 text-sm leading-relaxed line-clamp-2">{service.description}</p>
      </CardContent>
      <CardFooter>
        <Button className="w-full gradient-bg text-white font-semibold py-3" onClick={handleBookNow}>
          اكتشف المزيد واحجز الآن
        </Button>
      </CardFooter>
    </Card>
  );
};

const ServicesShowcasePage = ({ handleNavigation }) => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [currentPage, setCurrentPage] = useState(1);

  const filteredServices = useMemo(() => {
    return sampleServices
      .filter(service => 
        (selectedCategory === 'all' || service.category === selectedCategory) &&
        (service.name.toLowerCase().includes(searchTerm.toLowerCase()) || 
         service.location.toLowerCase().includes(searchTerm.toLowerCase()) ||
         service.description.toLowerCase().includes(searchTerm.toLowerCase()))
      );
  }, [searchTerm, selectedCategory]);

  const totalPages = Math.ceil(filteredServices.length / ITEMS_PER_PAGE);
  const paginatedServices = useMemo(() => {
    const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
    return filteredServices.slice(startIndex, startIndex + ITEMS_PER_PAGE);
  }, [filteredServices, currentPage]);

  return (
    <div className="min-h-screen bg-slate-50 py-12">
      <div className="container mx-auto px-4">
        <motion.div
          initial={{ opacity: 0, y: -30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.7 }}
          className="text-center mb-12"
        >
          <h1 className="text-5xl md:text-6xl font-extrabold gradient-text mb-4">اكتشف أفضل الخدمات لمناسبتك</h1>
          <p className="text-xl text-slate-600 max-w-3xl mx-auto">
            تصفح مجموعة واسعة من مزوّدي الخدمات المتميزين في منصة ليلة الليليوم، واختر الأنسب لاحتياجاتك.
          </p>
        </motion.div>

        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5, delay: 0.2 }}
          className="mb-10 p-6 bg-white rounded-xl shadow-lg border border-slate-200"
        >
          <div className="grid md:grid-cols-3 gap-4 items-end">
            <div className="md:col-span-2">
              <label htmlFor="search" className="block text-sm font-medium text-slate-700 mb-1">ابحث عن خدمة أو مكان</label>
              <div className="relative">
                <Input 
                  id="search"
                  type="text" 
                  placeholder="مثال: قاعة زفاف في الرياض، مصور فوتوغرافي..." 
                  className="pl-10 py-3 text-base"
                  value={searchTerm}
                  onChange={(e) => { setSearchTerm(e.target.value); setCurrentPage(1); }}
                />
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" />
              </div>
            </div>
            <div>
              <label htmlFor="category" className="block text-sm font-medium text-slate-700 mb-1">اختر الفئة</label>
              <Select value={selectedCategory} onValueChange={(value) => { setSelectedCategory(value); setCurrentPage(1); }} dir="rtl">
                <SelectTrigger className="w-full py-3 text-base">
                  <SelectValue placeholder="اختر فئة الخدمة" />
                </SelectTrigger>
                <SelectContent>
                  {Object.entries(serviceCategories).map(([key, { name, icon: Icon }]) => (
                    <SelectItem key={key} value={key} className="text-base py-2">
                      <div className="flex items-center gap-2">
                        <Icon className="w-5 h-5 text-primary" />
                        {name}
                      </div>
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
          </div>
        </motion.div>

        {paginatedServices.length > 0 ? (
          <>
            <motion.div 
              className="grid md:grid-cols-2 lg:grid-cols-3 gap-8"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ duration: 0.5, delay: 0.4 }}
            >
              {paginatedServices.map((service, index) => (
                <motion.div
                  key={service.id}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.5, delay: index * 0.1 + 0.4 }}
                >
                  <ServiceCard service={service} handleNavigation={handleNavigation} />
                </motion.div>
              ))}
            </motion.div>

            {totalPages > 1 && (
              <motion.div 
                className="flex items-center justify-center mt-12 space-x-2 space-x-reverse"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 0.5, delay: 0.6 }}
              >
                <Button variant="outline" size="icon" onClick={() => setCurrentPage(1)} disabled={currentPage === 1}><ChevronsRight className="h-5 w-5" /></Button>
                <Button variant="outline" size="icon" onClick={() => setCurrentPage(p => Math.max(1, p - 1))} disabled={currentPage === 1}><ChevronRight className="h-5 w-5" /></Button>
                <span className="text-slate-700 font-medium">صفحة {currentPage} من {totalPages}</span>
                <Button variant="outline" size="icon" onClick={() => setCurrentPage(p => Math.min(totalPages, p + 1))} disabled={currentPage === totalPages}><ChevronLeft className="h-5 w-5" /></Button>
                <Button variant="outline" size="icon" onClick={() => setCurrentPage(totalPages)} disabled={currentPage === totalPages}><ChevronsLeft className="h-5 w-5" /></Button>
              </motion.div>
            )}
          </>
        ) : (
          <motion.div 
            className="text-center py-16"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.5, delay: 0.4 }}
          >
            <SlidersHorizontal className="w-24 h-24 text-slate-300 mx-auto mb-6" />
            <h2 className="text-2xl font-bold text-slate-700 mb-2">لا توجد خدمات تطابق بحثك</h2>
            <p className="text-slate-500">حاول تغيير كلمات البحث أو الفلاتر المستخدمة.</p>
          </motion.div>
        )}
      </div>
    </div>
  );
};

export default ServicesShowcasePage;