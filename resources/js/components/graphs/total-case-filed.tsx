import { Scale } from 'lucide-react';
import { Card, CardAction, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";

interface SectionCardsProps {
  totalRabCasesFiled: number;
}

export function SectionCards({ totalRabCasesFiled }: SectionCardsProps) {
  return (
    <div className="grid grid-cols-1 gap-2 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
         className="w-[715px] shadow-sm h-[100px] flex items-center justify-center rounded-xl mx-auto"
        style={{
          background:
            "radial-gradient(circle, rgba(245, 127, 23, 0.9) 0%, rgba(251, 192, 45, 0.9) 100%)",
        }}
      >
        <CardHeader className="flex items-center gap-3 px-6 py-4 w-full">
          <div className="flex-shrink-0 rounded-full bg-[#fbc02d]/80 p-6 flex items-center justify-center border-4 border-white/70 shadow-inner shadow-yellow-400/30">
            <Scale className="text-yellow-900 w-10 h-10 drop-shadow-lg" />
          </div>

          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold drop-shadow-md text-center text-[18px] leading-tight">
              Total RAB Cases Filed
            </CardDescription>
            <CardTitle className="text-5xl font-bold tabular-nums text-white drop-shadow-lg text-center">
              {totalRabCasesFiled.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
