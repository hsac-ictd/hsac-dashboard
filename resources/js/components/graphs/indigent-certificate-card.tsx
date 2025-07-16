import { FileBadge } from "lucide-react";
import {
  Card,
  CardAction,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

interface CertificateIndigentCardProps {
  data: number;
}

export function CertificateIndigentCard({ data }: CertificateIndigentCardProps) {
  return (
    <div className="grid grid-cols-1 gap-2 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="shadow-sm h-[100px] flex items-center justify-center @container/card"
        style={{
          background:
            'radial-gradient(circle, rgba(0,0,128,0.9) 0%, rgba(0,255,255,0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-2 p-2 w-full">
          <div className="flex-shrink-0 rounded-full bg-[#000080]/60 p-2 flex items-center justify-center">
            <FileBadge className="text-cyan-300 w-8 h-8" />
          </div>

          <div className="flex-1 space-y-1">
            <CardDescription className="text-white font-semibold drop-shadow-md text-center text-[10px]">
              Certificate of Indigency Submitted
            </CardDescription>
            <CardTitle className="text-2xl font-bold tabular-nums text-white drop-shadow-lg text-center">
              {data.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  );
}
