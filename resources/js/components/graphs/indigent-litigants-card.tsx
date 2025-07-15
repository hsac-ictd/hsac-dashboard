import { FileChartPie } from 'lucide-react';
import {
  Card,
  CardAction,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

interface IndigentLitigantsCardProps {
  data: number;
}

export function IndigentLitigantsCard({ data }: IndigentLitigantsCardProps) {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="shadow-sm @container/card"
        style={{
          background: 'linear-gradient(90deg, rgba(20,15,60,0.9) 0%, rgba(9,9,121,0.9) 35%, rgba(0,212,255,0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          <div className="flex-shrink-0 rounded-full bg-[#10002b]/60 p-4">
            <FileChartPie className="text-cyan-400 size-10" />
          </div>

          <div className="flex-1">
            <CardDescription className="text-[#b3e6ff] font-semibold drop-shadow-md">
              Number of Indigent Litigants
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-white drop-shadow-lg text-center @[250px]/card:text-3xl">
              {data.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
