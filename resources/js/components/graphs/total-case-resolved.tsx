import { useEffect, useState } from "react";
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
  const [displayValue, setDisplayValue] = useState(0);

  useEffect(() => {
    let start = 0;
    const duration = 1500; // animation duration in ms
    let startTime: number | null = null;

    function animate(timestamp: number) {
      if (!startTime) startTime = timestamp;
      const progress = timestamp - startTime;
      const progressRatio = Math.min(progress / duration, 1); // clamp between 0 and 1

      const current = Math.floor(progressRatio * totalRabCasesResolved);
      setDisplayValue(current);

      if (progress < duration) {
        requestAnimationFrame(animate);
      } else {
        setDisplayValue(totalRabCasesResolved);
      }
    }

    requestAnimationFrame(animate);

    return () => {
      setDisplayValue(totalRabCasesResolved);
    };
  }, [totalRabCasesResolved]);

  return (
    <div className="grid grid-cols-1 gap-2 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="w-[715px] shadow-sm h-[100px] flex items-center justify-center rounded-xl mx-auto border border-[#fff176]"
        style={{
          background:
            "radial-gradient(circle, rgba(245, 127, 23, 0.9) 0%, rgba(251, 192, 45, 0.9) 50%, rgba(255, 241, 118, 0.9) 100%)",
        }}
      >
        <CardHeader className="flex items-center gap-3 px-6 py-4 w-full">
          <div className="flex-shrink-0 rounded-full bg-[#fbc02d]/80 p-6 flex items-center justify-center border-4 border-white/70 shadow-inner shadow-yellow-400/30">
            <Gavel className="text-yellow-800 w-10 h-10 drop-shadow-lg" />
          </div>

          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold text-center text-[18px] drop-shadow-md leading-tight">
              Total RAB Cases Disposed
            </CardDescription>
            <CardTitle className="text-5xl font-bold tabular-nums text-center text-white drop-shadow-lg">
              {displayValue.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
