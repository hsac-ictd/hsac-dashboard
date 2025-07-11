import { Gavel } from "lucide-react"
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"

export function TAppealedCasesResolvedCard() {
  return (
    <div className="grid grid-cols-1 gap-4 px-0 lg:px-0 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      <Card
        className="border border-[#94bbe9] shadow-sm @container/card"
        style={{
          background:
            'radial-gradient(circle, rgba(238, 174, 202, 0.9) 0%, rgba(148, 187, 233, 0.9) 100%)',
        }}
      >
        <CardHeader className="flex items-center gap-4">
          {/* Left-side connected icon */}
          <div className="flex-shrink-0 rounded-full bg-[#6a7fbf]/80 p-4 flex items-center justify-center">
            <Gavel className="text-[#4d5690] w-10 h-10" />
          </div>

          {/* Text content */}
          <div className="flex-1">
            <CardDescription className="text-[#3c4063] font-semibold drop-shadow-md">
              Total Appealed Cases Resolved
            </CardDescription>
            <CardTitle className="text-4xl font-bold tabular-nums text-center text-white drop-shadow-lg @[250px]/card:text-3xl">
              250
            </CardTitle>
          </div>

          <CardAction />
        </CardHeader>
      </Card>
    </div>
  )
}
