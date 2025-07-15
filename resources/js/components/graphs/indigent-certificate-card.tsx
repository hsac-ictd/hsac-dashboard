import { FileBadge } from "lucide-react"
import {
  Card,
  CardAction,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

interface CertificateIndigentCardProps {
  data: number;
}

export function CertificateIndigentCard({ data }: CertificateIndigentCardProps) {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="shadow-sm @container/card"
        style={{
          background:
            'radial-gradient(circle, rgba(0,0,128,0.9) 0%, rgba(0,255,255,0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          <div className="flex-shrink-0 rounded-full bg-[#000080]/60 p-4">
            <FileBadge className="text-cyan-300 size-10" />
          </div>

          <div className="flex-1">
            <CardDescription className="text-[#fff] font-semibold drop-shadow-md text-center">
              Certificate of Indigency Submitted
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
