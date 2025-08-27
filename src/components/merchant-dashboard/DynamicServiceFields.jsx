import React from 'react';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import { Controller } from 'react-hook-form';

const FormField = ({ id, label, error, children }) => (
    <div className="space-y-2">
        <Label htmlFor={id}>{label}</Label>
        {children}
        {error && <p className="text-sm text-red-500">{error.message}</p>}
    </div>
);

const PhotographyFields = ({ register, control, errors }) => (
    <div className="space-y-4">
        <FormField id="duration" label="مدة الخدمة (بالساعات)" error={errors.duration}>
            <Input id="duration" type="number" placeholder="3" {...register("duration")} />
        </FormField>
        <FormField id="photographerLevel" label="مستوى المصور" error={errors.photographerLevel}>
            <Controller name="photographerLevel" control={control} render={({ field }) => (
                <Select onValueChange={field.onChange} defaultValue={field.value}>
                    <SelectTrigger id="photographerLevel"><SelectValue /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="professional">محترف</SelectItem>
                        <SelectItem value="expert">خبير</SelectItem>
                        <SelectItem value="celebrity">مشهور</SelectItem>
                    </SelectContent>
                </Select>
            )}/>
        </FormField>
        <FormField id="includesVideo" label="هل تشمل تصوير فيديو؟" error={errors.includesVideo}>
            <Controller name="includesVideo" control={control} render={({ field }) => (
                 <div className="flex items-center space-x-2 space-x-reverse">
                    <Switch id="includesVideo" checked={field.value} onCheckedChange={field.onChange} />
                    <Label htmlFor="includesVideo" className="font-normal">نعم</Label>
                </div>
            )}/>
        </FormField>
    </div>
);

const VenueFields = ({ register, control, errors }) => (
    <div className="space-y-4">
        <FormField id="venueCapacity" label="سعة القاعة (عدد الأشخاص)" error={errors.venueCapacity}>
            <Input id="venueCapacity" type="number" placeholder="150" {...register("venueCapacity")} />
        </FormField>
        <FormField id="cateringOptions" label="خيارات الضيافة" error={errors.cateringOptions}>
            <Controller name="cateringOptions" control={control} render={({ field }) => (
                <Select onValueChange={field.onChange} defaultValue={field.value}>
                    <SelectTrigger id="cateringOptions"><SelectValue /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="none">بدون ضيافة</SelectItem>
                        <SelectItem value="buffet">بوفيه مفتوح</SelectItem>
                        <SelectItem value="set_menu">قائمة محددة</SelectItem>
                        <SelectItem value="external_allowed">يُسمح بالضيافة الخارجية</SelectItem>
                    </SelectContent>
                </Select>
            )}/>
        </FormField>
        <FormField id="hasSoundSystem" label="هل تحتوي على نظام صوتي متكامل؟" error={errors.hasSoundSystem}>
             <Controller name="hasSoundSystem" control={control} render={({ field }) => (
                 <div className="flex items-center space-x-2 space-x-reverse">
                    <Switch id="hasSoundSystem" checked={field.value} onCheckedChange={field.onChange} />
                    <Label htmlFor="hasSoundSystem" className="font-normal">نعم</Label>
                </div>
            )}/>
        </FormField>
    </div>
);

const BeautyFields = ({ register, control, errors }) => (
    <div className="space-y-4">
        <FormField id="makeupArtistLevel" label="مستوى خبيرة التجميل" error={errors.makeupArtistLevel}>
             <Controller name="makeupArtistLevel" control={control} render={({ field }) => (
                <Select onValueChange={field.onChange} defaultValue={field.value}>
                    <SelectTrigger id="makeupArtistLevel"><SelectValue /></SelectTrigger>
                    <SelectContent>
                        <SelectItem value="junior">مبتدئة</SelectItem>
                        <SelectItem value="senior">خبيرة</SelectItem>
                        <SelectItem value="master">خبيرة معتمدة</SelectItem>
                    </SelectContent>
                </Select>
            )}/>
        </FormField>
        <FormField id="makeupBrands" label="ماركات المكياج المستخدمة" error={errors.makeupBrands}>
            <Textarea id="makeupBrands" placeholder="مثال: شانيل، ديور، ميك أب فور أيفر..." {...register("makeupBrands")} />
        </FormField>
    </div>
);


const DynamicServiceFields = ({ category, register, control, errors }) => {
    switch (category) {
        case 'photography':
            return <PhotographyFields register={register} control={control} errors={errors} />;
        case 'venue':
            return <VenueFields register={register} control={control} errors={errors} />;
        case 'beauty':
            return <BeautyFields register={register} control={control} errors={errors} />;
        default:
            return <p className="text-sm text-slate-500">لا توجد حقول إضافية لهذه الفئة. يمكنك تحديد فئة الخدمة من صفحات إدارة الخدمات.</p>;
    }
};

export default DynamicServiceFields;