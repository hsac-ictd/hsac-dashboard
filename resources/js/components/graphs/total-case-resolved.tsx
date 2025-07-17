import { Gavel } from "lucide-react";
import {
  Card,
  CardAction,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

interface TResolvedCardsProps {
  totalRabCasesResolved: number;
}

export function TResolvedCards({ totalRabCasesResolved }: TResolvedCardsProps) {
  return (
    <div className="grid grid-cols-1 gap-2 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#fff176] shadow-sm h-[100px] flex items-center justify-center @container/card rounded-xl"
        style={{
          background:
            "radial-gradient(circle, rgba(245, 127, 23, 0.9) 0%, rgba(251, 192, 45, 0.9) 50%, rgba(255, 241, 118, 0.9) 100%)",
        }}
      >
        <CardHeader className="flex items-center gap-3 px-6 py-4 w-full">
          {/* Left-side Gavel icon */}
          <div className="flex-shrink-0 rounded-full bg-[#fbc02d]/60 p-6 flex items-center justify-center border-4 border-white/70 shadow-inner shadow-yellow-400/30">
            <Gavel className="text-yellow-800 w-10 h-10 drop-shadow-lg" />
          </div>

          {/* Text content */}
          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold text-center text-[18px] drop-shadow-md leading-tight">
              Total Regional Cases Resolved
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-white drop-shadow-lg">
              {totalRabCasesResolved.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
