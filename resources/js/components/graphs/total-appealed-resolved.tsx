import { Gavel } from "lucide-react"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

interface TAppealedCasesResolvedCardProps {
  data: number;
}

export function TAppealedCasesResolvedCard({ data }: TAppealedCasesResolvedCardProps) {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#rgba(102, 204, 153, 0.9)] shadow-sm @container/card"
        style={{
          background:
            'radial-gradient(circle, rgba(0, 153, 51, 0.9) 0%, rgba(102, 204, 153, 0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          <div className="flex-shrink-0 rounded-full bg-[#009933]/80 p-4 flex items-center justify-center">
            <Gavel className="text-white w-10 h-10" />
          </div>

          <div className="flex-1">
            <CardDescription className="text-white font-semibold drop-shadow-md text-center">
              Total Appealed Cases Resolved
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-white drop-shadow-lg @[250px]/card:text-3xl">
              {data.toLocaleString()}
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
