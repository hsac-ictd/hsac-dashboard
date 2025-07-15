"use client"

import { Bar, BarChart, CartesianGrid, XAxis, LabelList } from "recharts"

import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card"
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

export function RabCaseTypeChart({
  data,
}: {
  data: Array<{
    name: string;
    newCasesFiled: number;
    disposed: number;
  }>;
}) {
  const totalNewCasesFiled = data.reduce((acc, cur) => acc + cur.newCasesFiled, 0);
  const totalDisposed = data.reduce((acc, cur) => acc + cur.disposed, 0);

  const orange = " rgba(44,154,147,0.9)";
  const yellow = "#eecb4cff";

  const chartConfig = {
    newCasesFiled: {
      label: "Cases Filed",
      color: orange,
    },
    disposed: {
      label: "Disposed",
      color: yellow,
    },
  } satisfies ChartConfig;

  const currentYear = new Date().getFullYear();

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg h-80">
      <CardHeader>
        <CardTitle>RAB CASE TYPE</CardTitle>
        <CardDescription>{currentYear} - Present</CardDescription>
      </CardHeader>
      <CardContent>
        <div className="mb-4 flex gap-6 text-sm font-semibold">
          <div style={{ color: orange }}>
            Total Cases Filed: {totalNewCasesFiled}
          </div>
          <div style={{ color: yellow }}>
            Total Disposed: {totalDisposed}
          </div>
        </div>

        <ChartContainer config={chartConfig}>
          <BarChart
            data={data}
            margin={{ top: 20, right: 20, left: 20, bottom: 40 }}
          >
            <CartesianGrid vertical={false} />
            <XAxis
              dataKey="name"
              tickLine={false}
              tickMargin={10}
              axisLine={false}
            />
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent indicator="dashed" />}
            />
            <Bar dataKey="newCasesFiled" fill={orange} radius={4}>
              <LabelList
                dataKey="newCasesFiled"
                position="bottom"
                offset={10}
                style={{ fill: orange, fontWeight: 600, fontSize: 12 }}
              />
            </Bar>
            <Bar dataKey="disposed" fill={yellow} radius={4}>
              <LabelList
                dataKey="disposed"
                position="bottom"
                offset={10}
                style={{ fill: yellow, fontWeight: 600, fontSize: 12 }}
              />
            </Bar>
          </BarChart>
        </ChartContainer>
      </CardContent>
    </Card>
  );
}
