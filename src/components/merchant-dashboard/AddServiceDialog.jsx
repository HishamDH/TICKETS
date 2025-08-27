import React, { useEffect, useState, useCallback } from 'react';
import { useForm, Controller } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import * as z from 'zod';
import { v4 as uuidv4 } from 'uuid';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useToast } from '@/components/ui/use-toast';
import { PlusCircle, Package, DollarSign, Users, Clock, Info, Aperture, Wind, Droplets } from 'lucide-react';
import { Switch } from '@/components/ui/switch';
import { Calendar } from '@/components/ui/calendar';
import { format, startOfDay } from 'date-fns';
import { ar } from 'date-fns/locale';
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import DynamicServiceFields from './DynamicServiceFields';

const serviceSchema = z.object({
  serviceType: z.string(),
  name: z.string().min(3, "الاسم يجب أن يكون 3 أحرف على الأقل"),
  description: z.string().optional(),
  pricingModel: z.string(),
  price: z.preprocess(
    (a) => parseFloat(z.string().parse(a)),
    z.number().positive("السعر يجب أن يكون رقماً موجباً")
  ),
  availableSlots: z.preprocess(
    (a) => (a === '' ? undefined : parseInt(z.string().parse(a), 10)),
    z.number().positive("العدد المتاح يجب أن يكون رقماً موجباً").optional()
  ),
  onlineBookingEnabled: z.boolean().refine(val => val === true, {
    message: "تفعيل البيع أونلاين إلزامي.",
  }),
  serviceDates: z.array(z.date()).min(1, "يجب اختيار يوم واحد على الأقل"),
  category: z.string(),
  // Dynamic fields with optional validation
  duration: z.string().optional(),
  photographerLevel: z.string().optional(),
  includesVideo: z.boolean().optional(),
  venueCapacity: z.string().optional(),
  cateringOptions: z.string().optional(),
  hasSoundSystem: z.boolean().optional(),
  makeupArtistLevel: z.string().optional(),
  makeupBrands: z.string().optional(),
});


const serviceTypeDescriptions = {
  package: "الباقة المتكاملة: عرض شامل يجمع عدة خدمات بسعر واحد (مثل: باقة زفاف تشمل قاعة، بوفيه، وتصوير).",
  individual: "الخدمة الفردية: خدمة واحدة مستقلة يمكن للعميل حجزها بمفردها (مثل: حجز جلسة تصوير فقط).",
  addon: "الإضافة (Add-on): خدمة صغيرة إضافية لا يمكن حجزها إلا مع باقة أو خدمة أساسية (مثل: إضافة ساعة تصوير إضافية للباقة).",
};

const FormField = ({ id, label, error, children }) => (
    <div className="space-y-2">
        <Label htmlFor={id} className="font-semibold">{label}</Label>
        {children}
        {error && <p className="text-sm text-red-500">{error.message}</p>}
    </div>
);

const AddServiceDialog = ({ isOpen, onOpenChange, serviceCategory, suggestedServiceName, onServiceAdded, onAddonAdded }) => {
  const { toast } = useToast();
  
  const { register, handleSubmit, control, reset, watch, formState: { errors } } = useForm({
    resolver: zodResolver(serviceSchema),
    defaultValues: {
      serviceType: 'package',
      name: '',
      description: '',
      pricingModel: 'fixed',
      price: '',
      availableSlots: '1',
      onlineBookingEnabled: true,
      serviceDates: [],
      category: 'general',
      duration: '',
      photographerLevel: 'professional',
      includesVideo: false,
      venueCapacity: '',
      cateringOptions: 'none',
      hasSoundSystem: true,
      makeupArtistLevel: 'senior',
      makeupBrands: '',
    }
  });

  const serviceType = watch('serviceType');

  useEffect(() => {
    if (isOpen) {
      reset({
        serviceType: 'package',
        name: suggestedServiceName || '',
        description: '',
        pricingModel: 'fixed',
        price: '',
        availableSlots: '1',
        onlineBookingEnabled: true,
        serviceDates: [],
        category: serviceCategory || 'general',
        duration: '',
        photographerLevel: 'professional',
        includesVideo: false,
        venueCapacity: '',
        cateringOptions: 'none',
        hasSoundSystem: true,
        makeupArtistLevel: 'senior',
        makeupBrands: '',
      });
    }
  }, [isOpen, serviceCategory, suggestedServiceName, reset]);


  const processSubmit = (data) => {
    const commonData = {
        ...data,
        price: Number(data.price),
        id: uuidv4(),
        available: true,
    };
    
    if (data.serviceType === 'individual' && onServiceAdded) {
      onServiceAdded(commonData);
      toast({ title: '👍 تم إضافة الخدمة بنجاح!' });
    } else if (data.serviceType === 'addon' && onAddonAdded) {
      onAddonAdded(commonData);
      toast({ title: '👍 تم إضافة الإضافة بنجاح!' });
    } else {
      // Handle package logic here in the future
      console.log("Package data to be handled:", commonData);
      toast({
        title: '👍 تم إضافة الباقة بنجاح!',
        description: `تمت إضافة "${data.name}" لـ ${data.serviceDates.length} يوم/أيام. (محاكاة)`,
      });
    }

    onOpenChange(false);
  };
  
  const serviceTypeIcon = {
        'photography': <Aperture className="w-10 h-10 text-primary" />,
        'venue': <Wind className="w-10 h-10 text-primary" />,
        'beauty': <Droplets className="w-10 h-10 text-primary" />,
  }[serviceCategory] || <PlusCircle className="w-10 h-10 text-primary" />;


  return (
    <Dialog open={isOpen} onOpenChange={onOpenChange}>
      <DialogContent className="sm:max-w-4xl bg-white dark:bg-slate-900 shadow-2xl border-slate-200 dark:border-slate-700 rounded-xl" dir="rtl">
        <DialogHeader className="items-center text-center pb-6">
          <div className="p-3 bg-primary/10 rounded-full inline-block mb-3">
             {serviceTypeIcon}
          </div>
          <DialogTitle className="text-2xl font-bold text-slate-800 dark:text-slate-100">
            {serviceCategory ? `إضافة خدمة جديدة في: ${serviceCategory}` : 'إضافة باقة أو خدمة جديدة'}
          </DialogTitle>
          <DialogDescription className="text-slate-600 dark:text-slate-400 mt-1">
            املأ التفاصيل لإنشاء عرض جديد لعملائك. يمكنك تحديد عدة أيام لتطبيق نفس الخدمة عليها.
          </DialogDescription>
        </DialogHeader>
        <form onSubmit={handleSubmit(processSubmit)} className="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 p-2 max-h-[70vh] overflow-y-auto">
          {/* Right Column: Form Fields */}
          <div className="space-y-4">
            <div className="bg-slate-50 p-4 rounded-lg border">
              <h3 className="font-bold text-lg mb-4 text-slate-700">المعلومات الأساسية</h3>
              <div className="space-y-4">
                <FormField id="serviceType" label="نوع الخدمة" error={errors.serviceType}>
                   <Controller name="serviceType" control={control} render={({ field }) => (
                      <Select onValueChange={field.onChange} defaultValue={field.value}>
                        <SelectTrigger id="serviceType"><SelectValue /></SelectTrigger>
                        <SelectContent>
                          <SelectItem value="package">📦 باقة متكاملة</SelectItem>
                          <SelectItem value="individual">🧩 خدمة فردية</SelectItem>
                          <SelectItem value="addon">➕ إضافة (Add-on)</SelectItem>
                        </SelectContent>
                      </Select>
                   )}/>
                   <Alert className="mt-2 text-sm bg-blue-50 border-blue-200">
                      <Info className="h-4 w-4 text-blue-500" />
                      <AlertTitle className="font-semibold text-blue-800">ما هو الفرق؟</AlertTitle>
                      <AlertDescription className="text-blue-700">
                        {serviceTypeDescriptions[serviceType]}
                      </AlertDescription>
                    </Alert>
                </FormField>
                
                <FormField id="name" label="اسم الخدمة/الباقة" error={errors.name}>
                  <Input id="name" placeholder="مثال: باقة الزفاف الماسية" {...register("name")} />
                </FormField>

                <FormField id="description" label="الوصف العام" error={errors.description}>
                  <Textarea id="description" placeholder="صف الخدمة بشكل جذاب وواضح للعميل..." {...register("description")} rows={3} />
                </FormField>
              </div>
            </div>

            <div className="bg-slate-50 p-4 rounded-lg border">
              <h3 className="font-bold text-lg mb-4 text-slate-700">التسعير</h3>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                 <FormField id="pricingModel" label="نموذج التسعير" error={errors.pricingModel}>
                   <Controller name="pricingModel" control={control} render={({ field }) => (
                     <Select onValueChange={field.onChange} defaultValue={field.value}>
                        <SelectTrigger id="pricingModel"><SelectValue /></SelectTrigger>
                        <SelectContent>
                          <SelectItem value="fixed"><DollarSign className="inline-block w-4 h-4 ml-2" />سعر ثابت</SelectItem>
                          <SelectItem value="per_person"><Users className="inline-block w-4 h-4 ml-2" />لكل شخص</SelectItem>
                          <SelectItem value="per_hour"><Clock className="inline-block w-4 h-4 ml-2" />بالساعة</SelectItem>
                        </SelectContent>
                      </Select>
                   )} />
                </FormField>
                <FormField id="price" label="السعر (ريال)" error={errors.price}>
                  <Input id="price" type="number" placeholder="5000" {...register("price")} />
                </FormField>
              </div>
            </div>
          </div>
          
          {/* Left Column: Calendar & Dynamic Fields */}
          <div className="space-y-4">
             <div className="bg-slate-50 p-4 rounded-lg border">
                <h3 className="font-bold text-lg mb-4 text-slate-700">تفاصيل إضافية خاصة بالخدمة</h3>
                <DynamicServiceFields
                    category={serviceCategory}
                    register={register}
                    control={control}
                    errors={errors}
                />
            </div>
             <FormField id="serviceDates" label="حدد أيام الخدمة" error={errors.serviceDates}>
                <p className="text-sm text-slate-500 -mt-2">اختر يوماً أو أكثر من التقويم لتطبيق هذه الخدمة عليها.</p>
                <Controller
                  name="serviceDates"
                  control={control}
                  render={({ field }) => (
                    <div className="border rounded-md p-2 bg-white">
                        <Calendar
                            mode="multiple"
                            selected={field.value}
                            onSelect={field.onChange}
                            initialFocus
                            locale={ar}
                            disabled={(date) => date < startOfDay(new Date())}
                            footer={
                                <p className="text-sm p-2 text-center text-slate-600">
                                {field.value?.length > 0 ? `لقد اخترت ${field.value.length} يوم.` : "الرجاء اختيار يوم واحد على الأقل."}
                                </p>
                            }
                        />
                    </div>
                  )}
                />
            </FormField>

            <FormField id="availableSlots" label="العدد المتاح للحجز لكل يوم" error={errors.availableSlots}>
              <Input id="availableSlots" type="number" placeholder="1" {...register("availableSlots")} />
              <p className="text-xs text-slate-500">اتركه فارغاً لعدد غير محدود.</p>
            </FormField>
            
            <FormField id="onlineBookingEnabled" label="تفعيل البيع أونلاين لهذه الخدمة (إلزامي)" error={errors.onlineBookingEnabled}>
                 <Controller name="onlineBookingEnabled" control={control} render={({ field }) => (
                    <div className="flex items-center space-x-2 space-x-reverse mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <Switch id="onlineBookingEnabled" checked={field.value} onCheckedChange={field.onChange} />
                        <Label htmlFor="onlineBookingEnabled" className="mb-0 font-semibold text-blue-800">تفعيل البيع أونلاين</Label>
                    </div>
                 )}/>
            </FormField>
          </div>
           <DialogFooter className="pt-6 sm:justify-between border-t mt-4 col-span-1 md:col-span-2">
               <Button type="button" variant="ghost" onClick={() => onOpenChange(false)}>
                إلغاء
              </Button>
              <Button type="submit" className="w-full sm:w-auto gradient-bg text-white shadow-md hover:shadow-lg transition-shadow">
                <Package className="w-4 h-4 ml-2" />
                حفظ وإنشاء الخدمة
              </Button>
            </DialogFooter>
        </form>
      </DialogContent>
    </Dialog>
  );
};

export default AddServiceDialog;