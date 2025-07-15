import { Gavel } from "lucide-react";
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

interface TResolvedCardsProps {
  totalRabCasesResolved: number;
}

export function TResolvedCards({ totalRabCasesResolved }: TResolvedCardsProps) {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#rgba(255, 241, 118, 0.9)] shadow-sm @container/card"
        style={{
          background:
            "radial-gradient(circle, rgba(245, 127, 23, 0.9) 0%, rgba(251, 192, 45, 0.9) 50%, rgba(255, 241, 118, 0.9) 100%)",
        }}
      >
        <CardHeader className="flex items-center gap-4">
          {/* Left-side Book icon */}
          <div className="flex-shrink-0 rounded-full bg-[#fbc02d]/60 p-4 flex items-center justify-center">
            <Gavel className="text-yellow-800 w-10 h-10" />
          </div>

          {/* Text content */}
          <div className="flex-1">
            <CardDescription className="text-white font-semibold drop-shadow-md text-center">
              Total Regional Cases Resolved
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-white drop-shadow-lg @[250px]/card:text-3xl">
              {totalRabCasesResolved.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
