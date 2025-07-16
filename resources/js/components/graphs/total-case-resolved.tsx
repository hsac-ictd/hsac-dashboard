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
        className="border border-[#fff176] shadow-sm h-[100px] flex items-center justify-center @container/card"
        style={{
          background:
            "radial-gradient(circle, rgba(245, 127, 23, 0.9) 0%, rgba(251, 192, 45, 0.9) 50%, rgba(255, 241, 118, 0.9) 100%)",
        }}
      >
        <CardHeader className="flex items-center gap-2 p-2 w-full">
          {/* Left-side Gavel icon */}
          <div className="flex-shrink-0 rounded-full bg-[#fbc02d]/60 p-2 flex items-center justify-center">
            <Gavel className="text-yellow-800 w-8 h-8" />
          </div>

          {/* Text content */}
          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold text-center text-[10px] drop-shadow-md">
              Total Regional Cases Resolved
            </CardDescription>
            <CardTitle className="text-2xl font-bold tabular-nums text-center text-white drop-shadow-lg">
              {totalRabCasesResolved.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
