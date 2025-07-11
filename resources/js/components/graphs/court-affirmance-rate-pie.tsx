import { Pie, PieChart, Cell } from "recharts"

import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {
  ChartConfig,
  ChartContainer,
} from "@/components/ui/chart"

export const description = "A pie chart with dummy data and legend"

const darkPink = "#ff2056"
const lightPink = "#ffa1ad"

const chartData = [
  { name: "Affirmed Decisions", value: 250, fill: darkPink },
  { name: "Reversed Decisions", value: 100, fill: lightPink },
]

const chartConfig = {
  value: {
    label: "Decisions",
  },
  "Affirmed Decisions": {
    label: "Affirmed Decisions",
    color: darkPink,
  },
  "Reversed Decisions": {
    label: "Reversed Decisions",
    color: lightPink,
  },
} satisfies ChartConfig

export function CourtAffirmanceRatePie() {
  const total = chartData.reduce((acc, cur) => acc + cur.value, 0)

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
      <CardHeader className="items-center pb-0">
        <CardTitle>SUPREME COURT AFFIRMANCE - RATE</CardTitle>
        <CardDescription>January - June 2024</CardDescription>
      </CardHeader>
      <CardContent className="flex-1 pb-0">
        <ChartContainer config={chartConfig} className="mx-auto max-h-[300px]">
          <div className="flex items-center justify-center gap-6">
            <PieChart width={200} height={180}>
              <Pie
                data={chartData}
                dataKey="value"
                nameKey="name"
                cx="40%"
                cy="50%"
                outerRadius={70}
                label={({ value, x, y }) => {
                  const percent = ((value / total) * 100).toFixed(1)
                  return (
                    <text
                      x={x}
                      y={y}
                      fill="#7a182c"
                      textAnchor={x > 90 ? "end" : "start"}
                      dominantBaseline="central"
                      fontWeight="600"
                      fontSize={12}
                    >
                      {`${percent}%`}
                    </text>
                  )
                }}
                labelLine={false}
              >
                {chartData.map((entry) => (
                  <Cell key={entry.name} fill={entry.fill} />
                ))}
              </Pie>
            </PieChart>

            <div className="flex flex-col gap-1">
              {chartData.map(({ name, fill }) => (
                <div key={name} className="flex items-center gap-2">
                  <div
                    className="w-3 h-3 rounded-sm"
                    style={{ backgroundColor: fill }}
                  />
                  <span className="font-semibold text-xs text-[#7a182c]">{name}</span>
                </div>
              ))}
            </div>
          </div>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}
