import React from 'react';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogDescription, DialogFooter, DialogClose } from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { ScrollArea } from "@/components/ui/scroll-area"; 
import { CheckCircle, Shield } from 'lucide-react';
import { useToast } from "@/components/ui/use-toast";

const TermsAndConditionsModal = ({ isOpen, onClose, onAccept }) => {
  const { toast } = useToast();

  const handleAcceptWithToast = () => {
    onAccept();
    toast({
        title: "تمت الموافقة بنجاح!",
        description: "لقد وافقت على شروط وأحكام البيع الإلكتروني.",
        className: "bg-green-500 text-white",
    });
  };
  
  return (
    <Dialog open={isOpen} onOpenChange={onClose} dir="rtl">
      <DialogContent className="sm:max-w-[600px]">
        <DialogHeader>
          <DialogTitle className="flex items-center gap-2 text-2xl">
            <Shield className="w-7 h-7 text-primary"/>
            شروط وأحكام البيع الإلكتروني عبر ليلة الليليوم
          </DialogTitle>
          <DialogDescription className="pt-2">
            يرجى قراءة الشروط التالية بعناية قبل تفعيل خاصية البيع الإلكتروني لخدماتك أو باقاتك عبر منصة ليلة الليليوم. الموافقة على هذه الشروط تعني التزامك الكامل بها.
          </DialogDescription>
        </DialogHeader>
        
        <ScrollArea className="h-[300px] p-4 border rounded-md bg-slate-50 my-4">
          <div className="space-y-3 text-sm text-slate-700">
            <p><strong>1. العمولة:</strong> سيتم خصم عمولة بنسبة <strong>3%</strong> (أو النسبة المحددة في اتفاقية الخدمة الخاصة بك) من قيمة كل حجز يتم تأكيده ودفعه عبر منصة ليلة الليليوم. سيتم توضيح المبلغ المخصوم في تفاصيل الحجز وفي كشوفات التسوية المالية.</p>
            <p><strong>2. سياسة الإلغاء والتأكيد:</strong> للمنصة الحق في إلغاء الحجز خلال <strong>24 ساعة</strong> من إنشائه إذا لم يتم تأكيده بشكل نهائي من طرفي العقد (العميل ومزوّد الخدمة) عبر النظام. تطبق سياسات الإلغاء والاسترداد المحددة من قبل مزود الخدمة والمعروضة للعميل عند الحجز.</p>
            <p><strong>3. العقود الإلكترونية:</strong> يجب على كل من العميل ومزوّد الخدمة توقيع العقد إلكترونيًا عبر منصة ليلة الليليوم لإتمام الحجز. يعتبر التوقيع الإلكتروني ملزمًا قانونيًا لكلا الطرفين.</p>
            <p><strong>4. مسؤولية تقديم الخدمة:</strong> يظل مزوّد الخدمة هو المسؤول الأول عن جودة الخدمة المقدمة للعميل وتطابقها مع الوصف المقدم في المنصة. ليلة الليليوم هي وسيط تقني لتسهيل عملية الحجز والدفع.</p>
            <p><strong>5. التسويات المالية:</strong> سيتم تحويل مستحقات مزوّد الخدمة بعد خصم العمولة إلى محفظته في المنصة خلال فترة زمنية محددة (عادة خلال 48 ساعة من اكتمال الخدمة وتأكيد العميل). يمكن للمزوّد طلب سحب رصيده وفقًا لسياسات السحب المعتمدة.</p>
            <p><strong>6. بيانات العملاء:</strong> يلتزم مزوّد الخدمة بالحفاظ على سرية بيانات العملاء التي يحصل عليها عبر المنصة وعدم استخدامها لأي أغراض أخرى غير المتعلقة بتقديم الخدمة المحجوزة، وذلك وفقًا لسياسة الخصوصية للمنصة.</p>
            <p><strong>7. تحديث الشروط:</strong> تحتفظ منصة ليلة الليليوم بالحق في تحديث هذه الشروط والأحكام من وقت لآخر. سيتم إشعار مزوّدي الخدمات بأي تغييرات جوهرية عبر البريد الإلكتروني المسجل أو من خلال إشعار داخل المنصة.</p>
            <p><strong>8. عرض الأسعار والتوفر:</strong> يلتزم مزود الخدمة بتحديث الأسعار والتواريخ المتاحة بدقة وفي الوقت المناسب. أي حجوزات تتم بناءً على معلومات غير صحيحة قد تخضع للمراجعة أو الإلغاء بالتنسيق مع مزود الخدمة.</p>
            <p><strong>9. حل النزاعات:</strong> في حال نشوء أي نزاع بين العميل ومزود الخدمة، ستقوم منصة ليلة الليليوم بدور الوسيط لمحاولة حل النزاع وديًا بناءً على الشروط والأحكام والعقد الموقع. قرار المنصة في هذا الشأن يعتبر نهائيًا في حدود وساطتها.</p>
          </div>
        </ScrollArea>

        <DialogFooter className="gap-2 sm:justify-start">
          <DialogClose asChild>
            <Button type="button" variant="outline">
              إغلاق
            </Button>
          </DialogClose>
          <Button type="button" onClick={handleAcceptWithToast} className="gradient-bg text-white">
            <CheckCircle className="w-4 h-4 ml-2"/>
            أوافق على الشروط والأحكام
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
};

export default TermsAndConditionsModal;