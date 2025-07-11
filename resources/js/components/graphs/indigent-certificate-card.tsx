import { FileCheck } from "lucide-react"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

export function CertificateIndigentCard() {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#00d4ff] shadow-sm @container/card"
        style={{
          background: 'linear-gradient(90deg, rgba(20,15,60,0.9) 0%, rgba(9,9,121,0.9) 35%, rgba(0,212,255,0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          {/* Left-side icon representing "connected document" */}
          <div className="flex-shrink-0 rounded-full bg-[#10002b]/60 p-4">
            <FileCheck className="text-cyan-400 size-10" />
          </div>

          {/* Text content */}
          <div className="flex-1">
            <CardDescription className="text-[#b3e6ff] font-semibold drop-shadow-md">
              Certificate of Indigency Submitted
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-white drop-shadow-lg text-center @[250px]/card:text-3xl">
              322
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
