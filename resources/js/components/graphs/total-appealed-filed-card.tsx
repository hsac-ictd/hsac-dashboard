import { Scale } from 'lucide-react';
import {
  Card,
  CardAction,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

interface TAppealedCasesFiledCardProps {
  data: number;
}

export function TAppealedCasesFiledCard({ data }: TAppealedCasesFiledCardProps) {
  return (
    <div className="grid grid-cols-1 gap-2 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#66cc99] shadow-sm h-[100px] flex items-center justify-center @container/card rounded-xl"
        style={{
          background:
            'radial-gradient(circle, rgba(0, 153, 51, 0.9) 0%, rgba(102, 204, 153, 0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-3 px-6 py-4 w-full">
          <div className="flex-shrink-0 rounded-full bg-[#009933]/80 p-6 flex items-center justify-center border-4 border-white/70 shadow-inner shadow-green-400/40">
            <Scale className="text-white w-10 h-10 drop-shadow-lg" />
          </div>

          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold text-center text-[18px] drop-shadow-md leading-tight">
              Total Appealed Cases Filed
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-white drop-shadow-lg">
              {data.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
